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
     * Função responsável por retornar um JSON padronizado com o
     * status de sucesso (status = 1) e status HTTP 200
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
            'data'   => $dados,
            'msg'    => null
        );

        // Retorna um JSON
        return response()->json(
            $returnData
        );
    }

    /**
     * Função responsável por retornar um JSON padronizado com o
     * status de erro tratado (status = 0) e status HTTP 500
     *
     * @param string $mensagem A mensagem de erro
     *
     * @return JsonResponse JSON contendo o erro tratado
     */
    static function retornaErroTratado($mensagem)
    {
        // Modelo o array dos dados
        $returnData = array(
            'status' => 0,
            'data'   => null,
            'msg'    => $mensagem
        );

        // Retorna um JSON
        return response()->json(
            $returnData,
            500
        );
    }
}