<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpRequestException;

class ConflictException extends HttpRequestException
{
    const STATUS_CODE = 409;
}
