<?php

namespace THS\Utils\Exception;

use OEG\Integration\Lib\Response\Request\ReturnWrapper;

class APIException extends BasicStorableDataException
{
    /** @var ReturnWrapper Retorno do recurso da API. */
    private $returnWrapper;

    public function __construct($message, array $data = [], $code = 0, $previous = null, ReturnWrapper $returnWrapper = null)
    {
        parent::__construct($message, $data, $code, $previous);

        $this->returnWrapper = $returnWrapper;
    }

    /**
     * Retorna a propriedade {@see APIException::$returnWrapper}.
     *
     * @return ReturnWrapper
     */
    public function getReturnWrapper()
    {
        return $this->returnWrapper;
    }

    /**
     * Define a propriedade {@see APIException::$returnWrapper}.
     *
     * @param ReturnWrapper $returnWrapper
     *
     * @return APIException
     */
    public function setReturnWrapper($returnWrapper)
    {
        $this->returnWrapper = $returnWrapper;
        return $this;
    }
}
