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
     * Retorna uma hash da senha.
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
     * Valida uma hash de senha.
     *
     * @param string $strHashed
     * @param string $hash
     *
     * @return string
     */
    public static function check(string $strHashed, string $hash): string
    {
        return password_verify($strHashed, $hash);
    }
}
