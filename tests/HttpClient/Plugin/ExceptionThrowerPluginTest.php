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
use Transip\Api\Library\HttpClient\Plugin\ExceptionThrowerPlugin;

final class ExceptionThrowerPluginTest extends TestCase
{
    /**
     * @dataProvider responsesDataProvider
     */
    public function testExceptionThrowerWithRequest(
        ResponseInterface $response,
        ApiException $exception = null
    ): void {
        $request = new Request('GET', 'https://api.transip.eu/v6');
        $promise = new HttpFulfilledPromise($response);
        $plugin = new ExceptionThrowerPlugin();

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

        if ($exception) {
            $this->expectException(get_class($exception));
            $this->expectExceptionCode($exception->getCode());
            $this->expectExceptionMessageMatches('/'.preg_quote($exception->getMessage(), '/').'$/');
        }

        $result->wait();
    }

    /**
     * @return array
     */
    public static function responsesDataProvider(): array
    {
        return [
            '200 Response' => [
                'response' => new Response(),
                'exception' => null,
            ],
            '201 Response' => [
                'response' => new Response(),
                'exception' => null,
            ],
        ];
    }
}
