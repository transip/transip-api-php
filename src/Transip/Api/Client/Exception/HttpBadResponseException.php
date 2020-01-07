<?php

namespace Transip\Api\Client\Exception;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;
use Transip\Api\Client\Exception\HttpRequest\BadResponseException;
use Transip\Api\Client\Exception\HttpRequest\ConflictException;
use Transip\Api\Client\Exception\HttpRequest\ForbiddenException;
use Transip\Api\Client\Exception\HttpRequest\InternalServerErrorException;
use Transip\Api\Client\Exception\HttpRequest\MethodNotAllowedException;
use Transip\Api\Client\Exception\HttpRequest\NotAcceptableException;
use Transip\Api\Client\Exception\HttpRequest\NotFoundException;
use Transip\Api\Client\Exception\HttpRequest\NotImplementedException;
use Transip\Api\Client\Exception\HttpRequest\BadResponseTimeoutException;
use Transip\Api\Client\Exception\HttpRequest\TooManyBadResponseException;
use Transip\Api\Client\Exception\HttpRequest\UnauthorizedException;
use Transip\Api\Client\Exception\HttpRequest\UnprocessableEntityException;

class HttpBadResponseException extends Exception
{
    /**
     * @var Exception $innerException
     */
    private $innerException;

    /**
     * @var ResponseInterface $response
     */
    private $response;

    /**
     * @param string            $message
     * @param int               $code
     * @param Exception         $innerException
     * @param ResponseInterface $response
     */
    public function __construct(string $message, int $code, Exception $innerException, ResponseInterface $response)
    {
        $this->innerException = $innerException;
        $this->response       = $response;
        parent::__construct($message, $code);
    }

    public static function badResponseException(Exception $innerException, ResponseInterface $response): self
    {
        $errorMessage    = $response->getBody();
        $decodedResponse = json_decode($errorMessage, true);
        $errorMessage    = $decodedResponse['error'] ?? $response->getBody();

        switch($response->getStatusCode()) {
            case BadResponseException::STATUS_CODE:
                return new BadResponseException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case UnauthorizedException::STATUS_CODE:
                return new UnauthorizedException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case ForbiddenException::STATUS_CODE:
                return new ForbiddenException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case NotFoundException::STATUS_CODE:
                return new NotFoundException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case MethodNotAllowedException::STATUS_CODE:
                return new MethodNotAllowedException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case NotAcceptableException::STATUS_CODE:
                return new NotAcceptableException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case BadResponseTimeoutException::STATUS_CODE:
                return new BadResponseTimeoutException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case ConflictException::STATUS_CODE:
                return new ConflictException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case UnprocessableEntityException::STATUS_CODE:
                return new UnprocessableEntityException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case TooManyBadResponseException::STATUS_CODE:
                return new TooManyBadResponseException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case InternalServerErrorException::STATUS_CODE:
                return new InternalServerErrorException($errorMessage, $response->getStatusCode(), $innerException, $response);
            case NotImplementedException::STATUS_CODE:
                return new NotImplementedException($errorMessage, $response->getStatusCode(), $innerException, $response);
            default:
                return new HttpBadResponseException($errorMessage, $response->getStatusCode(), $innerException, $response);
        }
    }
}
