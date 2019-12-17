<?php


namespace Transip\Api\Client\Exception;

class HttpRequestException extends HttpClientException
{
    public static function requestException(\Exception $innerException)
    {
        return new self("HttpRequestException: {$innerException->getMessage()}", $innerException);
    }
}
