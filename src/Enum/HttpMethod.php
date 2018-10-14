<?php

namespace THS\Utils\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Tipos de métodos Http.
 *
 * @method static HttpMethod GET()
 * @method static HttpMethod POST()
 * @method static HttpMethod PUT()
 * @method static HttpMethod DELETE()
 * @method static HttpMethod PATCH()
 *
 * @author Thiago Hofmeister <thiago.hofmeister@gmail.com>
 */
final class HttpMethod extends AbstractEnumeration
{
    /** @var string Método GET. */
    const GET = 'GET';

    /** @var string Método POST. */
    const POST = 'POST';

    /** @var string Método PUT. */
    const PUT = 'PUT';

    /** @var string Método DELETE. */
    const DELETE = 'DELETE';

    /** @var string Método PATCH. */
    const PATCH = 'PATCH';
}
