<?php

namespace Transip\Api\Library\Exception;

use RuntimeException;

class ApiClientException extends RuntimeException
{
    const CODE_API_RESPONSE_MISSING_PARAMETER = 1101;

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }

    public static function parameterMissingInResponse(array $response, string $parameterName): self
    {
        $parameters = implode(', ', array_keys($response));
        return new self(
            "Required parameter '{$parameterName}' missing from response, got {$parameters}",
            self::CODE_API_RESPONSE_MISSING_PARAMETER
        );
    }
}
