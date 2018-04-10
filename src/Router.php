<?php

namespace MDW\Utils;

/**
 * Router formatter.
 *
 * @author Thiago Hofmeister <thiago.souza@moovin.com.br>
 */
class Router
{
    /**
     * Returns the concatenated domain with a string passed by parameter.
     *
     * @param string $path
     *
     * @return string
     */	
    public static function parser (string $path): string
    {
        return self::getDomainUrl() . '/' . $path;
    }

    /**
     * Returns website domain.
     *
     * @return string
     */
    private static function getDomainUrl (): string
    {
        $protocol = strtolower(reset(explode('/', $_SERVER['SERVER_PROTOCOL']))) . '://';

        return implode('/', [
            $protocol,
            $_SERVER['HTTP_HOST']
        ]);
    }
}
