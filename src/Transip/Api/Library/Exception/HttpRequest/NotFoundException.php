<?php

namespace Transip\Api\Library\Exception\HttpRequest;

use Transip\Api\Library\Exception\HttpBadResponseException;

class NotFoundException extends HttpBadResponseException
{
    const STATUS_CODE = 404;
}
