<?php

namespace Transip\Api\Client\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Transip\Api\Client\Exception\ApiException;
use Transip\Api\Client\Exception\HttpClientException;
use Transip\Api\Client\Exception\HttpRequestException;
use Exception;

class GuzzleClient implements HttpClientInterface
{
    /**
     * @var Client $client
     */
    protected $client;

    public function __construct(string $token)
    {
        $this->client = new Client(['headers' => ['Authorization' => "Bearer {$token}"]]);
    }

    public function get(string $url): array
    {
        try {
            $response = $this->client->get($url);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
        }

        if ($response->getStatusCode() !== 200) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody === false) {
            throw ApiException::emptyResponse($response);
        }

        return $responseBody;
    }

    public function post(string $url, array $content): array
    {
        // TODO: Implement post() method.
    }

    public function put(string $url, array $content): array
    {
        // TODO: Implement put() method.
    }

    public function patch(string $url, array $content): array
    {
        // TODO: Implement patch() method.
    }

    public function delete(string $url): array
    {
        // TODO: Implement delete() method.
    }
}
