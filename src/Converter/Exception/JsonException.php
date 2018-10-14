<?php

namespace THS\Utils\Converter\Exception;

use Exception;

/**
 * Trata de exceções lançadas durante a conversão dos tipos para json e vice versa.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class JsonException extends Exception
{
    /** @var mixed $data Dados da tentativa de conversão. */
    protected $data;

    /**
     * Retorna os dados da tentativa de conversão.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Define os dados da tentativa de conversão.
     *
     * @param mixed $data
     *
     * @return JsonException
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
