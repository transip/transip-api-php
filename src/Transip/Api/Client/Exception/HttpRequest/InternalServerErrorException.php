<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpBadResponseException;

class InternalServerErrorException extends HttpBadResponseException
{
    const STATUS_CODE = 500;
}
