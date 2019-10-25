<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpRequestException;

class BadRequestException extends HttpRequestException
{
    const STATUS_CODE = 400;
}
