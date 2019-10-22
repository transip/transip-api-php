<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpRequestException;

class InternalServerErrorException extends HttpRequestException
{
    CONST STATUS_CODE = 500;
}
