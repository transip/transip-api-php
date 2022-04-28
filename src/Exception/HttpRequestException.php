<?php


namespace Transip\Api\Library\Exception;

class HttpRequestException extends HttpClientException
{
    public static function requestException(\Exception $innerException): self
    {
        return new self("HttpRequestException: {$innerException->getMessage()}", $innerException);
    }
}
