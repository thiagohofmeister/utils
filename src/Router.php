<?php

namespace MDW\Utils;

/**
 * Formatador de rotas.
 *
 * @author Thiago Hofmeister <thiago.souza@moovin.com.br>
 */
class Router
{
    public static function parser (string $path)
    {
        return self::getDomainUrl() . '/' . $path;
    }

    private static function getDomainUrl ()
    {
        $protocol = strtolower(reset(explode('/', $_SERVER['SERVER_PROTOCOL']))) . '://';

        return implode('/', [
            $protocol,
            $_SERVER['HTTP_HOST']
        ]);
    }
}
