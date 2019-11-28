<?php

namespace Transip\Api\Client\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Transip\Api\Client\Exception\ApiException;
use Transip\Api\Client\Exception\HttpClientException;
use Transip\Api\Client\Exception\HttpConnectException;
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

    public function get(string $url, array $content = []): array
    {
        $options = [];
        if (count($content) > 0) {
            $options['query'] = $content;
        }

        try {
            $response = $this->client->get($url, $options);
        } catch (ConnectException $connectException) {
            throw HttpConnectException::connectException($connectException);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
        }

        if ($response->getStatusCode() !== 200) {
            throw ApiException::unexpectedStatusCode($response);
        }

        if ($response->getBody() == null) {
            throw ApiException::emptyResponse($response);
        }

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody === null) {
            throw ApiException::malformedJsonResponse($response);
        }

        return $responseBody;
    }

    public function post(string $url, array $content = []): void
    {
        $options['body'] = json_encode($content);

        try {
            $response = $this->client->post($url, $options);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
        }

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    public function put(string $url, array $content): void
    {
        $options['body'] = json_encode($content);

        try {
            $response = $this->client->put($url, $options);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
        }

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    public function patch(string $url, array $content): void
    {
        $options['body'] = json_encode($content);

        try {
            $response = $this->client->patch($url, $options);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
        }

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    public function delete(string $url, array $content = []): void
    {
        $options['body'] = json_encode($content);

        try {
            $response = $this->client->delete($url, $options);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
        }

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }
}
