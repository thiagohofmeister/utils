<?php

namespace THS\Utils\Response\Facade;

use THS\Utils\Response;

/**
 * Empacotador dos retornos de métodos do facade dos pacotes.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
class ReturnWrapper
{
    /** @var Response\Request\ReturnWrapper[] Conjunto dos empacotadores do retorno de cada recurso. */
    private $resourceWrappers;

    /** @var mixed Dados do retorno do método do facade. */
    private $content;

    /**
     * Retorna a propriedade {@see ReturnWrapper::$resourceWrappers}.
     *
     * @return Response\Request\ReturnWrapper[]
     */
    public function getResourceWrappers()
    {
        return $this->resourceWrappers;
    }

    /**
     * Define a propriedade {@see ReturnWrapper::$resourceWrappers}.
     *
     * @param Response\Request\ReturnWrapper[] $resourceWrappers
     *
     * @return ReturnWrapper
     */
    public function setResourceWrappers($resourceWrappers)
    {
        $this->resourceWrappers = $resourceWrappers;

        return $this;
    }

    /**
     * Adiciona um elemento à propriedade {@see ReturnWrapper::$resourceWrappers}.
     *
     * @param Response\Request\ReturnWrapper $resourceWrapper
     *
     * @return ReturnWrapper
     */
    public function addResourceWrapper(Response\Request\ReturnWrapper $resourceWrapper)
    {
        $this->resourceWrappers[] = $resourceWrapper;

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

    /**
     * Retorna o resumo de todas as requisições armazenadas.
     *
     * @return array
     */
    public function getRequestsSummary()
    {
        $requestsSummary = [];
        foreach ($this->getResourceWrappers() as $resourceWrapper) {
            $requestsSummary[] = $resourceWrapper->getRequestSummary();
        }

        return $requestsSummary;
    }
}
