<?php

namespace App\Http\Controllers;

use App\Models\ProdCron;
use Illuminate\Http\JsonResponse;

use App\Utils\RequestUtils;
use Illuminate\Support\Facades\DB;

/**
 * Classe base da aplicação, chamada no caminho '/' no navegador ou POSTMAN
 */
class AppController extends Controller
{
    /**
     * Função responsável por retornar os dados da aplicação
     *
     * @return JsonResponse
     */
    public function basePath()
    {
        // Inicializo o array dos dados
        $data = array(
            'project_name' => env('APP_NAME', 'Laravel Project'),
            'project_mode' => env('APP_ENV', 'prod'),
            'db_status'    => DB::connection()->getPdo() ? 'online' : 'offline'
        );

        // Recupero a ultima vez que o cron executou
        $data['last_cron_execution'] = ProdCron::max('executed_in');

        // Recupero o status de memoria atual do sistema
        $statusFile = file_get_contents("/proc/meminfo");

        // Valido se retornou dados
        if ($statusFile == false) {
            // Preencho os dados como vazio para a memória
            $data['mem_usage'] = 'unknow';

        } else {
            // Separo os dados por linha em um array
            $memoryData = explode("\n", $statusFile);

            // Modelo o array com os dados principais
            $data['mem_usage'] = array(
                $memoryData[0],
                $memoryData[1],
                $memoryData[2]
            );
        }

        // Retorno JSON com os dados
        return RequestUtils::retornaSucesso($data);
    }

    public function basePHP()
    {
        return phpinfo();
    }
}
