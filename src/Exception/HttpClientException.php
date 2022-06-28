<?php

namespace Transip\Api\Library\Exception;

use Exception;
use RuntimeException;
use Throwable;

class HttpClientException extends RuntimeException
{
    /**
     * @var Throwable $innerException
     */
    private $innerException;

    /**
     * @param string    $message
     * @param Throwable $innerException
     */
    public function __construct(string $message, Throwable $innerException)
    {
        $this->innerException = $innerException;
        parent::__construct($message);
    }

    public static function genericRequestException(Throwable $innerException): self
    {
        return new self("Generic HTTP Client Exception: {$innerException->getMessage()}", $innerException);
    }

    public function innerException(): Throwable
    {
        return $this->innerException;
    }
}
