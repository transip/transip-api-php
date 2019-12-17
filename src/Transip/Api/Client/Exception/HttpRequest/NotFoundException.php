<?php

namespace Transip\Api\Client\Exception\HttpRequest;

use Transip\Api\Client\Exception\HttpBadResponseException;

class NotFoundException extends HttpBadResponseException
{
    const STATUS_CODE = 404;
}
