<?php

namespace Transip\Api\Client\Exception;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ApiException extends Exception
{
    CONST CODE_API_EMPTY_RESPONSE = 1001;

    CONST CODE_API_UNEXPECTED_STATUS_CODE = 1002;

    CONST CODE_API_MALFORMED_JSON_RESPONSE = 1003;

    /**
     * @var ResponseInterface $response
     */
    private $response;

    /**
     * @param string $message
     * @param int $code
     * @param ResponseInterface $response
     */
    public function __construct(string $message, int $code, ResponseInterface $response)
    {
        $this->response = $response;
        parent::__construct($message, $code);
    }

    public static function emptyResponse(ResponseInterface $response): self
    {
        return new self(
            "Api returned statuscode {$response->getStatusCode()}, but the response was empty",
            self::CODE_API_EMPTY_RESPONSE,
            $response
        );
    }

    public static function malformedJsonResponse(ResponseInterface $response): self
    {
        return new self(
            "Api returned statuscode {$response->getStatusCode()}, but the response was not json decodable",
            self::CODE_API_MALFORMED_JSON_RESPONSE,
            $response
        );
    }

    public static function unexpectedStatusCode(ResponseInterface $response): self
    {
        $responseBody = $response->getBody();

        if (json_decode($response->getBody(), true) !== false) {
            $responseBody = json_decode($response->getBody(), true);
        }

        return new self(
            "Api returned unexpected statuscode {$response->getStatusCode()}:  {$responseBody}",
            self::CODE_API_UNEXPECTED_STATUS_CODE,
            $response
        );
    }

    public function response(): ResponseInterface
    {
        return $this->response;
    }
}
