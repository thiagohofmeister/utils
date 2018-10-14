<?php

namespace THS\Utils\Response\Request;

/**
 * Empacotador dos retornos de métodos do recurso dos pacotes.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class ReturnWrapper
{
    /** @var array Resumo da requisição feita no recurso. */
    private $requestSummary;

    /** @var mixed Conteúdo do retorno do método chamado do recurso. */
    private $content;

    /**
     * Retorna a propriedade {@see ReturnWrapper::$requestSummary}.
     *
     * @return array
     */
    public function getRequestSummary()
    {
        return $this->requestSummary;
    }

    /**
     * Define a propriedade {@see ReturnWrapper::$requestSummary}.
     *
     * @param array $requestSummary
     *
     * @return ReturnWrapper
     */
    public function setRequestSummary($requestSummary)
    {
        $this->requestSummary = $requestSummary;

        return $this;
    }

    /**
     * Retorna a propriedade {@see ReturnWrapper::$content}.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Define a propriedade {@see ReturnWrapper::$content}.
     *
     * @param mixed $content
     *
     * @return ReturnWrapper
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
