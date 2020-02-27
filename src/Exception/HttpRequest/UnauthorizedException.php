<?php

namespace Transip\Api\Library\Exception\HttpRequest;

use Transip\Api\Library\Exception\HttpBadResponseException;

class UnauthorizedException extends HttpBadResponseException
{
    const STATUS_CODE = 401;
}
