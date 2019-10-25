<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpRequestException;

class NotFoundException extends HttpRequestException
{
    const STATUS_CODE = 404;
}
