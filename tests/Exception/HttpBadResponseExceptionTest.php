<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Exception;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Exception\HttpBadResponseException;

final class HttpBadResponseExceptionTest extends TestCase
{
    public function testCanGetPreviousExceptionAndRepsonse(): void
    {
        $previous = new \RuntimeException('Previous exception');
        $response = new Response(200, [], json_encode(['foo' => 'bar']));
        $exception = new HttpBadResponseException('test', 0, $previous, $response);

        self::assertEquals($previous, $exception->getPrevious());
        self::assertEquals($response, $exception->getResponse());
    }

    public function testCanGetInnerExceptionAndRepsonse(): void
    {
        $previous = new \RuntimeException('Previous exception');
        $response = new Response(200, [], json_encode(['foo' => 'bar']));
        $exception = new HttpBadResponseException('test', 0, $previous, $response);

        self::assertEquals($previous, $exception->getInnerException());
        self::assertEquals($response, $exception->getResponse());
    }
}
