<?php

namespace THS\Utils;

/**
 * Classe responsável por gerar e validar hashes.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class Hash
{
    /**
     * Retorna uma hash da string.
     *
     * @param string $str
     *
     * @return string
     */
    public static function make(string $str): string
    {
        return password_hash($str, PASSWORD_BCRYPT);
    }

    /**
     * Valida uma string por uma hash.
     *
     * @param string $strToCheck
     * @param string $hash
     *
     * @return string
     */
    public static function check(string $strToCheck, string $hash): string
    {
        return password_verify($strToCheck, $hash);
    }
}
