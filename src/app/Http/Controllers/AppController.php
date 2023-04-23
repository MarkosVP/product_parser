<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Utils\RequestUtils;

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
            'project_mode' => env('APP_ENV', 'prod')
        );

        // Retorno JSON com os dados
        return RequestUtils::retornaSucesso($data);
    }

    public function basePHP()
    {
        return phpinfo();
    }
}
