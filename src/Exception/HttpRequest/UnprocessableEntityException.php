<?php

namespace Transip\Api\Library\Exception\HttpRequest;

use Transip\Api\Library\Exception\HttpBadResponseException;

class UnprocessableEntityException extends HttpBadResponseException
{
    const STATUS_CODE = 422;
}
