<?php

namespace Transip\Api\Library\Exception;

use RuntimeException;
use Psr\Http\Message\ResponseInterface;

class ApiException extends RuntimeException
{
    const CODE_API_EMPTY_RESPONSE = 1001;

    const CODE_API_UNEXPECTED_STATUS_CODE = 1002;

    const CODE_API_MALFORMED_JSON_RESPONSE = 1003;

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
            "Api returned statuscode {$response->getStatusCode()}, but the response was not json decodable" . PHP_EOL . $response->getBody(),
            self::CODE_API_MALFORMED_JSON_RESPONSE,
            $response
        );
    }

    public static function unexpectedStatusCode(ResponseInterface $response): self
    {
        $responseBody = $response->getBody();

        if (json_decode($response->getBody(), true) !== null) {
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
