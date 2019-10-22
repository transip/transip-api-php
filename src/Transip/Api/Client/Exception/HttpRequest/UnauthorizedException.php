<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpRequestException;

class UnauthorizedException extends HttpRequestException
{
    CONST STATUS_CODE = 401;
}
