<?php

namespace THS\Utils\Encoder\Contract;

/**
 * Interface com métodos que o codificador deve implementar.
 * Métodos para codificar (encode) e decodificar (decode).
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
interface Codifiable
{
    /**
     * Converte pra outro charset a string recebida pelo parâmetro
     * do tipo do codificador
     *
     * @param mixed $data Dados a serem decodificados do tipo do codificador
     *
     * @return mixed Dados decodificados do tipo do codificador
     */
    public static function decode($data);

    /**
     * Converte para o tipo do codificador os dados recebidos pelo parâmetro
     *
     * @param mixed $data Dados a serem codificados para o tipo do codificador
     *
     * @return mixed Dados codificados para o tipo do codificador
     */
    public static function encode($data);
}
