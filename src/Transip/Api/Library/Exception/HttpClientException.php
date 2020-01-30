<?php

namespace Transip\Api\Library\Exception;

use Exception;
use RuntimeException;

class HttpClientException extends RuntimeException
{
    /**
     * @var Exception $innerException
     */
    private $innerException;

    /**
     * @param string    $message
     * @param Exception $innerException
     */
    public function __construct(string $message, Exception $innerException)
    {
        $this->innerException = $innerException;
        parent::__construct($message);
    }

    public static function genericRequestException(Exception $innerException): self
    {
        return new self("Generic HTTP Client Exception: {$innerException->getMessage()}", $innerException);
    }

    public function innerException(): Exception
    {
        return $this->innerException;
    }
}
