<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

/**
 * Classe contendo funçõs uteis utilizadas pela aplicação
 * referente aos retornos para a Web
 */
abstract class RequestUtils
{
    /**
     * Classe responsável por padronizar o retorno dos dados das requisições
     * de Sucesso da aplicação
     *
     * @param array|string $dados Os dados a serem retornados
     *
     * @return JsonResponse JSON contendo os dados de retorno
     */
    static function retornaSucesso($dados = array())
    {
        // Modelo o array dos dados
        $returnData = array(
            'status' => 1,
            'data'   => $dados
        );

        // Retorna um JSON com status HTTP 200 e status 1
        return response()->json(
            $returnData
        );
    }
}