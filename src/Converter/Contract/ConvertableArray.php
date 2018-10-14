<?php

namespace THS\Utils\Converter\Contract;

/**
 * Interface com métodos que o conversor deve implementar para ser tratado.
 * como convertível do seu tipo para array e de array para o seu tipo.
 *
 * @author Thiago Hofmeister <thiago.souza@moovin.com.br>
 */
interface ConvertableArray
{
    /**
     * Converte pra array os dados recebidos pelo parâmetro do tipo do conversor
     *
     * @param mixed $data Dados que será convertido para array.
     *
     * @return array Dados convertidos para array.
     */
    public static function toArray($data);

    /**
     * Converte para o tipo do conversor os dados recebidos pelo prâmetro
     * do tipo array.
     *
     * @param array $data Array que será convertido para o tipo do conversor.
     *
     * @return mixed Dados convertidos para o tipo do conversor.
     */
    public static function fromArray($data);
}
