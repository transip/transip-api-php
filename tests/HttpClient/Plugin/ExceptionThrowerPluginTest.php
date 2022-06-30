<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\HttpClient\Plugin;

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Promise\HttpFulfilledPromise;
use Http\Client\Promise\HttpRejectedPromise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Exception\ApiException;
use Transip\Api\Library\Exception\HttpBadResponseException;
use Transip\Api\Library\Exception\HttpRequest\AccessTokenException;
use Transip\Api\Library\Exception\HttpRequest\BadResponseException;
use Transip\Api\Library\Exception\HttpRequest\BadResponseTimeoutException;
use Transip\Api\Library\Exception\HttpRequest\ConflictException;
use Transip\Api\Library\Exception\HttpRequest\ForbiddenException;
use Transip\Api\Library\Exception\HttpRequest\InternalServerErrorException;
use Transip\Api\Library\Exception\HttpRequest\MethodNotAllowedException;
use Transip\Api\Library\Exception\HttpRequest\NotAcceptableException;
use Transip\Api\Library\Exception\HttpRequest\NotFoundException;
use Transip\Api\Library\Exception\HttpRequest\NotImplementedException;
use Transip\Api\Library\Exception\HttpRequest\RateLimitException;
use Transip\Api\Library\Exception\HttpRequest\UnauthorizedException;
use Transip\Api\Library\Exception\HttpRequest\UnprocessableEntityException;
use Transip\Api\Library\HttpClient\Plugin\ExceptionThrowerPlugin;

final class ExceptionThrowerPluginTest extends TestCase
{
    /**
     * @dataProvider responsesDataProvider
     */
    public function testExceptionThrowerWithRequest(
        ResponseInterface $response,
        HttpBadResponseException $exception = null
    ): void {
        $request = new Request('GET', 'https://api.transip.eu/v6');
        $promise = new HttpFulfilledPromise($response);
        $plugin = new ExceptionThrowerPlugin();

        if ($exception) {
            $this->expectException(get_class($exception));
            $this->expectExceptionCode($exception->getCode());
            $this->expectExceptionMessageMatches('/'.preg_quote($exception->getMessage(), '/').'$/');
        }

        $result = $plugin->handleRequest(
            $request,
            function (RequestInterface $request) use ($promise) {
                return $promise;
            },
            function (RequestInterface $request) use ($promise) {
                return $promise;
            }
        );

        if ($exception) {
            $this->assertInstanceOf(HttpRejectedPromise::class, $result);
        } else {
            $this->assertInstanceOf(HttpFulfilledPromise::class, $result);
        }

        $result->wait();
    }

    /**
     * @return array
     */
    public static function responsesDataProvider(): \Generator
    {
        $inner = new \Exception('inner');

        $data = [
            '200 Response' => [
                'response' => new Response(),
                'exception' => null,
            ],
            '201 Response' => [
                'response' => new Response(),
                'exception' => null,
            ],
            '500 Response' => [
                'response' => new Response(500, [], json_encode(['error' => 'Internal Server Error'])),
                'exception' => InternalServerErrorException::class
            ],
            '400 Response with message' => [
                'response' => new Response(400, [], json_encode(['error' => 'Some Error Description'])),
                'exception' => BadResponseException::class,
                'message' => 'Some Error Description',
            ],
            '400 Response empty body' => [
                'response' => new Response(400, [], ''),
                'exception' => BadResponseException::class,
            ],
            '401 Response' => [
                'response' => new Response(401, [], ''),
                'exception' => UnauthorizedException::class,
            ],
            '401 Response msg 1' => [
                'response' => new Response(401, [], json_encode(['error' => 'Your access token has been revoked.'])),
                'exception' => AccessTokenException::class,
            ],
            '401 Response msg 2' => [
                'response' => new Response(401, [], json_encode(['error' => 'Your access token has expired.'])),
                'exception' => AccessTokenException::class,
            ],
            '403 Response' => [
                'response' => new Response(403, []),
                'exception' => ForbiddenException::class,
            ],
            '404 Response' => [
                'response' => new Response(404, []),
                'exception' => NotFoundException::class,
            ],
            '405 Response' => [
                'response' => new Response(405, []),
                'exception' => MethodNotAllowedException::class,
            ],
            '406 Response' => [
                'response' => new Response(406, []),
                'exception' => NotAcceptableException::class,
            ],
            '408 Response' => [
                'response' => new Response(408, []),
                'exception' => BadResponseTimeoutException::class,
            ],
            '409 Response' => [
                'response' => new Response(409, []),
                'exception' => ConflictException::class,
            ],
            '422 Response' => [
                'response' => new Response(422, []),
                'exception' => UnprocessableEntityException::class,
            ],
            '429 Response' => [
                'response' => new Response(429, []),
                'exception' => RateLimitException::class,
            ],
            '501 Response' => [
                'response' => new Response(501, []),
                'exception' => NotImplementedException::class,
            ],
            // Should catch the generic error
            '599 Response' => [
                'response' => new Response(599, []),
                'exception' => HttpBadResponseException::class,
            ],
        ];

        foreach ($data as $name => $item) {
            yield $name => [
                'response' => $item['response'],
                'exception' => $item['exception'] === null ?
                    $item['exception'] :
                    new $item['exception'](
                        $item['message'] ?? '',
                        $item['response']->getStatusCode(),
                        $inner,
                        $item['response']
                    ),
            ];
        }
    }
}
