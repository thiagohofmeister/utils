<?php

namespace THS\Utils\Contract;

/**
 * Classe abstrata para paginação de integração com dados de APIs.
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
abstract class PaginatorAbstract
{
    /** @var mixed $data Dados da página atual. */
    protected $data;

    /** @var integer $pageNumber Numero atual da página. */
    protected $pageNumber;

    /** @var integer $pageSize Quantidade de registros por página.  */
    protected $pageSize;

    /** @var integer $totalPages Número total de páginas. */
    protected $totalPages;

    /**
     * PaginatorAbstract constructor.
     *
     * @param integer $pageSize Quantidade de registros por página.
     * @param integer $pageNumber Número da página atual.
     */
    public function __construct($pageSize, $pageNumber)
    {
        $this->pageSize = $pageSize;
        $this->pageNumber = $pageNumber;
    }

    /**
     * Retorna se o total de páginas atingiu seu limite.
     *
     * @return bool
     */
    public abstract function next();

    /**
     * Retorna os dados da página atual.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Define os dados da página atual.
     *
     * @param mixed $data
     *
     * @return PaginatorAbstract
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Retorna o número da página atual.
     *
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Define o número da página atual.
     *
     * @param int $pageNumber
     *
     * @return PaginatorAbstract
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
        return $this;
    }

    /**
     * Retorna o número de registros por página.
     *
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Define o número de registros por página.
     *
     * @param int $pageSize
     *
     * @return PaginatorAbstract
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * Retorna o número total de páginas.
     *
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * Define o número total de páginas.
     *
     * @param int $totalPages
     *
     * @return PaginatorAbstract
     */
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
        return $this;
    }
}
