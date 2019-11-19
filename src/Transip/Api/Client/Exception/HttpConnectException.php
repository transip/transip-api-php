<?php


namespace Transip\Api\Client\Exception;


use GuzzleHttp\Exception\ConnectException;

class HttpConnectException extends HttpClientException
{
    public static function connectException(ConnectException $innerException)
    {
        return new self("HttpConnectException: {$innerException->getMessage()}", $innerException);
    }
}
