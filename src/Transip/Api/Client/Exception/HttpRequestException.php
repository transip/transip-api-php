<?php

namespace Transip\Api\Client\Exception;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Transip\Api\Client\Exception\HttpRequest\BadRequestException;
use Transip\Api\Client\Exception\HttpRequest\ConflictException;
use Transip\Api\Client\Exception\HttpRequest\ForbiddenException;
use Transip\Api\Client\Exception\HttpRequest\InternalServerErrorException;
use Transip\Api\Client\Exception\HttpRequest\MethodNotAllowedException;
use Transip\Api\Client\Exception\HttpRequest\NotAcceptableException;
use Transip\Api\Client\Exception\HttpRequest\NotFoundException;
use Transip\Api\Client\Exception\HttpRequest\NotImplementedException;
use Transip\Api\Client\Exception\HttpRequest\RequestTimeoutException;
use Transip\Api\Client\Exception\HttpRequest\TooManyRequestException;
use Transip\Api\Client\Exception\HttpRequest\UnauthorizedException;
use Transip\Api\Client\Exception\HttpRequest\UnprocessableEntityException;

class HttpRequestException extends Exception
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

    public static function requestException(Exception $innerException, ResponseInterface $response): self
    {
        $errorMessage    = $response->getBody();
        $decodedResponse = json_decode($errorMessage, true);
        $errorMessage    = $decodedResponse['error'] ?? $response->getBody();

        switch($response->getStatusCode()) {
            case BadRequestException::STATUS_CODE:
                return new BadRequestException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case UnauthorizedException::STATUS_CODE:
                return new UnauthorizedException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case ForbiddenException::STATUS_CODE:
                return new ForbiddenException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case NotFoundException::STATUS_CODE:
                return new NotFoundException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case MethodNotAllowedException::STATUS_CODE:
                return new MethodNotAllowedException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case NotAcceptableException::STATUS_CODE:
                return new NotAcceptableException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case RequestTimeoutException::STATUS_CODE:
                return new RequestTimeoutException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case ConflictException::STATUS_CODE:
                return new ConflictException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case UnprocessableEntityException::STATUS_CODE:
                return new UnprocessableEntityException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case TooManyRequestException::STATUS_CODE:
                return new TooManyRequestException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case InternalServerErrorException::STATUS_CODE:
                return new InternalServerErrorException($errorMessage, $response->getStatusCode(), $innerException,$response);
            case NotImplementedException::STATUS_CODE:
                return new NotImplementedException($errorMessage, $response->getStatusCode(), $innerException,$response);
            default:
                return new HttpRequestException($errorMessage, $response->getStatusCode(), $innerException,$response);
        }
    }

    public function innerException(): Exception
    {
        return $this->innerException;
    }
}
