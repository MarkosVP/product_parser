<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

/**
 * Classe contendo funçõs uteis utilizadas pela aplicação
 */
abstract class Utils
{
    /**
     * Função responsável por converter uma string comum para uma versão
     * contendo somente os numerais
     *
     * @param string $string A string contendo caracteres variados
     *
     * @return string A mesma string contendo somente os números (Mantendo a ordem em que eles aparecem)
     */
    static function somenteNumeros($string)
    {
        // Remove todos os caracteres que não são números da string informada
        $string = preg_replace('/[^0-9]/', '', $string);

        // Valido se retornou a string corretamente
        if (!is_string($string)) {
            // Retorna vazio
            return '';
        }

        // Retorno a string numérica
        return $string;
    }
}