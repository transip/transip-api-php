<?php

namespace Transip\Api\Library\Exception;

use Exception;
use RuntimeException;
use Throwable;

class HttpClientException extends RuntimeException
{
    /**
     * @param string    $message
     * @param Exception $previous
     */
    public function __construct(string $message, Exception $previous)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function genericRequestException(Exception $innerException): self
    {
        return new self("Generic HTTP Client Exception: {$innerException->getMessage()}", $innerException);
    }

    /**
     * @deprecated
     * @see self::getPrevious()
     */
    public function innerException(): ?Throwable
    {
        return $this->getPrevious();
    }
}
