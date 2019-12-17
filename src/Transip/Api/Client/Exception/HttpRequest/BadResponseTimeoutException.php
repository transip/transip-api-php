<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpBadResponseException;

class BadResponseTimeoutException extends HttpBadResponseException
{
    const STATUS_CODE = 408;
}
