<?php

namespace THS\Utils\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Códigos de status de uma requisição HTTP.
 *
 * @method static HttpStatusCode OK()
 * @method static HttpStatusCode CREATED()
 * @method static HttpStatusCode NO_CONTENT()
 * @method static HttpStatusCode UNAUTHORIZED()
 * @method static HttpStatusCode NOT_FOUND()
 * @method static HttpStatusCode METHOD_NOT_ALLOWED()
 * @method static HttpStatusCode UNPROCESSABLE_ENTITY()
 * @method static HttpStatusCode INTERNAL_SERVER_ERROR()
 * @method static HttpStatusCode TOO_MANY_REQUESTS()
 * @method static HttpStatusCode BAD_REQUEST()
 *
 * @author Dantiéris Castilhos Rabelini <dantieris.rabelini@moovin.com.br>
 */
class HttpStatusCode extends AbstractEnumeration
{

    /** @var int */
    const OK = 200;

    /** @var int */
    const CREATED = 201;

    /** @var int Aceito para processamento e processamento não concluido. */
    const ACCEPTED = 202;

    /** @var int */
    const NO_CONTENT = 204;

    /** @var integer Requisição inválida */
    const BAD_REQUEST = 400;

    /** @var int */
    const UNAUTHORIZED = 401;

    /** @var int */
    const NOT_FOUND = 404;

    /** @var int */
    const METHOD_NOT_ALLOWED = 405;

    /** @var int */
    const UNPROCESSABLE_ENTITY = 422;

    /** @var int */
    const INTERNAL_SERVER_ERROR = 500;

    /** @var int */
    const TOO_MANY_REQUESTS = 429;
}
