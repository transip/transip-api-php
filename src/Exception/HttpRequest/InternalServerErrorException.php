<?php

namespace Transip\Api\Library\Exception\HttpRequest;

use Transip\Api\Library\Exception\HttpBadResponseException;

class InternalServerErrorException extends HttpBadResponseException
{
    const STATUS_CODE = 500;
}
