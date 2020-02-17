<?php

namespace Transip\Api\Library\Exception\HttpRequest;

use Transip\Api\Library\Exception\HttpBadResponseException;

class NotAcceptableException extends HttpBadResponseException
{
    const STATUS_CODE = 406;
}
