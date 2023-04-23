<?php

namespace App\Http\Controllers;

set_time_limit(900);

use App\Enums\Status;

use App\Models\ProdCron;
use App\Models\ProdCronErrors;
use App\Models\Product;

use App\Utils\RequestUtils;
use App\Utils\Utils;

use Exception;

class CronController extends Controller
{
    public function execute()
    {
        // Recupero o horário de execução da CRON
        $timeCron = env('CRON_SCHEDULED_TIME', '');

        // Valido se recuperou corretamente a string
        if (!is_string($timeCron)) {
            // Considero vazio
            $timeCron = '';
        }

        // Modelo a resposta padrão da CRON
        $response = 'OK';

        // Checo se o horário atual é igual ao tempo permitido
        if (!empty($timeCron) && (date('H:i') != $timeCron)) {
            // Retorno resposta genérica
            return RequestUtils::retornaSucesso($response);
        }

        // Gero um registro na tabela da Cron
        $cron = ProdCron::create();

        try {
            // Busco os arquivo a serem baixados
            $arquivos = $this->buscaArquivos();

            // Inicializo o contador de linhas
            $linha = 1;

            // Percorro o array dos veículos
            foreach ($arquivos as $arquivo) {
                // Busco os produtos do arquivo recuperado
                $produtos = $this->recuperaDadosArquivo($arquivo);

                // Percorro cada produto retornado
                foreach ($produtos as $produtoJSON) {
                    try {
                        // Recupero o JSON como um array
                        $dadosProd = json_decode($produtoJSON, true);

                        // Valido se retornou um array
                        if (!is_array($dadosProd)) {
                            // Gero Exceção
                            throw new Exception(
                                'Ocorreram erros durante a recuperação do Produto da linha' .
                                $linha . ' do arquivo ' . $arquivo
                            );
                        }

                        // Recupero o código do produto
                        $productID = (int)Utils::somenteNumeros($dadosProd['code']);

                        // Valido se já existe
                        $prod = Product::find($productID);

                        // Se localizou o registro
                        if (!empty($prod)) {
                            // Pulo o registro para evitar que substitua os dados após atualização
                            continue;
                        }

                        // Recupero a quantidade do produto
                        $prodQuantity = (int)Utils::somenteNumeros($dadosProd['quantity']);

                        // Insiro o produto no banco de dados
                        Product::create(array(
                            'code'             => $productID,
                            'status'           => Status::PUBLISHED,
                            'imported_t'       => date('Y-m-d H:i:s'),
                            'url'              => $dadosProd['url'],
                            'creator'          => $dadosProd['creator'],
                            'created_t'        => $dadosProd['created_t'],
                            'last_modified_t'  => $dadosProd['last_modified_t'],
                            'product_name'     => $dadosProd['product_name'],
                            'quantity'         => $prodQuantity,
                            'brands'           => $dadosProd['brands'],
                            'categories'       => $dadosProd['categories'],
                            'labels'           => $dadosProd['labels'],
                            'cities'           => $dadosProd['cities'],
                            'purchase_places'  => $dadosProd['purchase_places'],
                            'stores'           => $dadosProd['stores'],
                            'ingredients_text' => $dadosProd['ingredients_text'],
                            'traces'           => $dadosProd['traces'],
                            'serving_size'     => $dadosProd['serving_size'],
                            'serving_quantity' => (int)Utils::somenteNumeros($dadosProd['serving_quantity']),
                            'nutriscore_score' => (int)Utils::somenteNumeros($dadosProd['nutriscore_score']),
                            'nutriscore_grade' => $dadosProd['nutriscore_grade'],
                            'main_category'    => $dadosProd['main_category'],
                            'image_url'        => $dadosProd['image_url']
                        ));


                        // Incremento a quantidade de registros com sucesso na CRON atual
                        $cron->imported++;

                    } catch (Exception $ex) {
                        // Gero um registro de erro no banco para o ID da CRON gerada
                        ProdCronErrors::create(array(
                            'cron_id'     => $cron->id,
                            'registry_id' => $cron->imported_errors,
                            'error'       => $ex->getMessage(),
                            'error_data'  => $ex->getTraceAsString()
                        ));

                        // Incremento a quantidade de registros com falha na CRON atual
                        $cron->imported_errors++;
                    }

                    // Incremento o ID
                    $linha++;
                }

                // Limpo da memória a variável
                unset($produtos);
            }

        } catch (Exception $ex) {
            // Gero um registro de erro no banco para o ID da CRON gerada
            ProdCronErrors::create(array(
                'cron_id'     => $cron->id,
                'registry_id' => 1,
                'error'       => $ex->getMessage(),
                'error_data'  => $ex->getTraceAsString()
            ));

            // Informo falha para o CRON
            $response = 'ERROR';

            // Retorno resposta genérica
            return RequestUtils::retornaSucesso($response);
        }

        // Salvo as atualizações na cron
        $cron->save();

        // Retorno resposta genérica
        return RequestUtils::retornaSucesso($response);
    }

    /**
     * Recupera o array dos arquivos disponíveis no Open Food Facts
     *
     * @return array<string> Os nomes dos arquivos
     */
    private function buscaArquivos()
    {
        // Recupero a URL base das requisições
        $url = env('OPENFOODFACTS_BASEURL', '');

        // Inicializo o array dos dados
        $arquivos = array();

        // Checo se retornou corretamente os dados
        if (!is_string($url) || empty($url)) {
            // Gero exceção
            throw new Exception('URL de consulta/download dos arquivos não definida');
        }

        // Inicializo o CURL
        $curl = curl_init($url . 'index.txt');

        // Valido se retornou corretamente a instância CURL
        if ($curl == false) {
            // Gero Exceção
            throw new Exception('Falha na recuperação da instância do CURL');
        }

        // Configuro o CURL para retornar os dados da requisição
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Solicito os arquivos
        $response = curl_exec($curl);

        // Valido se retornou corretamente os dados
        if (is_bool($response)) {
            // Gero Exceção
            throw new Exception('Falha na recuperação da instância do CURL');
        }

        // Converto o arquivo TXT para um array
        $response = preg_split("/\r\n|\n|\r/", $response);

        // Checo se falhou na recuperação das strings
        if ($response == false) {
            // Gero Exceção
            throw new Exception('Falha na recuperação da lista de Arquivos');
        }

        // Checo se o último elemento é uma string vazia
        if (empty($response[count($response) - 1])) {
            // Removo o elemento vazio
            unset($response[count($response) - 1]);
        }

        // Retorno o array com os arquivos
        return $response;
    }

    /**
     * Função responsável por baixar, extrair e retornar os dados de cada produto do arquivo informado
     *
     * @param string $nomeArquivo O nome do arquivo a ser baixado que terá os dados extraidos
     *
     * @return array<string> Array com os JSONs de cada Produto
     */
    private function recuperaDadosArquivo($nomeArquivo)
    {
        // Recupero a URL base de download
        $url = env('OPENFOODFACTS_BASEURL', '');

        // Checo se recuperou corretamente os dados
        if (!is_string($url) || empty($url)) {
            // Gero exceção
            throw new Exception('URL de consulta/download dos arquivos não definida');
        }

        // Modelo a URL de recuperação dos dados
        $url .= $nomeArquivo;

        // Baixo os dados do arquivo
        $arquivo = file_get_contents($url);

        // Valido se recuperou corretamnete os dados
        if ($arquivo == false) {
            // Gero exceção
            throw new Exception('Falha no download do arquivo ' . $nomeArquivo);
        }

        // Recupero o diretório temporário do projeto
        $tempDir = env('TMP_DIR', '/');

        // Valido se não conseguiu recuperar corretamente o diretório da TEMP
        if (!is_string($tempDir)) {
            // Gero exceção
            throw new Exception('Falha na recuperação do diretório temporário');
        }

        // Salvo o arquivo na pasta temporária do Projeto
        file_put_contents($tempDir . '/' . $nomeArquivo, $arquivo);

        // Limpo a variável
        unset($arquivo);

        // Abro o arquivo comprimido baixado
        $arquivo = gzopen($tempDir . '/' . $nomeArquivo, 'rb');

        // Valido se abriu corrtemante o arquivo
        if ($arquivo == false) {
            // Gero exceção
            throw new Exception('Falha na leitura do arquivo ' . $nomeArquivo);
        }

        // Inicializo o array dos dados
        $produtos = array();

        // Leio o arquivo linha por linha
        while (!gzeof($arquivo)) {
            // Recupero uma linha do Arquivo
            $productJSON = gzgets($arquivo);

            // Valido se recuperou a linha corretamente
            if ($productJSON == false) {
                // Encerro a leitura do arquivo
                gzclose($arquivo);

                // Gero exceção
                throw new Exception('Falha na leitura do arquivo ' . $nomeArquivo);
            }

            // Concateno o JSON no array
            $produtos[] = $productJSON;

            // Checo se existem 100 registros no array
            if (count($produtos) == 100) {
                // Encerro o while
                break;
            }
        }

        // Encerro a leitura do arquivo
        gzclose($arquivo);

        // Limpo a variável
        unset($arquivo);

        // Deleto o arquivo comprimido
        unlink($tempDir . '/' . $nomeArquivo);

        // Retorno os produtos
        return $produtos;
    }
}
