<?php

namespace THS\Utils\Exception;

use Exception;

/**
 * Exceção que armazena os dados que a lançaram.
 * Exceção base para todas exceções que pretendem salvar os dados do momento
 * que ocorreu a exceção para poder serem logados posteriormente.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class BasicStorableDataException extends Exception
{
    /** @var array Estado dos dados no momento do lançamento da exceção */
    protected $data;

    /**
     * {@inheritdoc}
     * Além do comportamento padrão de uma exceção armazena os dados do erro.
     *
     * @param array $data Dados que causaram o erro
     */
    public function __construct($message, $data = [], $code = 0, $previous = null)
    {
        $this->data = $data;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Retorna os dados armazenados
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Define os dados armazenados
     *
     * @param array $data Dados dos objetos ao lançarem a exceção
     *
     * @return BasicStorableDataException
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
