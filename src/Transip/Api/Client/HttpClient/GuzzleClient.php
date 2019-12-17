<?php

namespace Transip\Api\Client\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Transip\Api\Client\Exception\ApiException;
use Transip\Api\Client\Exception\HttpClientException;
use Transip\Api\Client\Exception\HttpRequestException;
use Transip\Api\Client\Exception\HttpBadResponseException;
use Exception;

class GuzzleClient extends HttpClient implements HttpClientInterface
{
    /**
     * @var Client $client
     */
    private $client;

    public function __construct(string $endpoint)
    {
        $this->client = new Client();
        parent::__construct($this, $endpoint);
    }

    public function setToken(string $token): void
    {
        $this->client = new Client(['headers' => ['Authorization' => "Bearer {$token}"]]);
        $this->token = $token;
    }

    public function get(string $url, array $query = []): array
    {
        $options = [];
        if (count($query) > 0) {
            $options['query'] = $query;
        }

        $this->checkAndRenewToken();

        try {
            $response = $this->client->get("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $this->exceptionHandler($exception);
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

    public function post(string $url, array $body = []): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();

        try {
            $response = $this->client->post("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $this->exceptionHandler($exception);
        }

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    public function postAuthentication(string $url, string $signature, array $body): array
    {
        $options['headers'] = ['Signature' => $signature];
        $options['body']    = json_encode($body);

        try {
            $response = $this->client->post("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $this->exceptionHandler($exception);
        }

        if ($response->getStatusCode() !== 201) {
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

    public function put(string $url, array $body): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();

        try {
            $response = $this->client->put("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $this->exceptionHandler($exception);
        }

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    public function patch(string $url, array $body): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();

        try {
            $response = $this->client->patch("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $this->exceptionHandler($exception);
        }

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    public function delete(string $url, array $body = []): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();

        try {
            $response = $this->client->delete("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $this->exceptionHandler($exception);
        }

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }
    }

    private function exceptionHandler(Exception $exception): void
    {
        $class = get_class($exception);
        switch ($class) {
            case BadResponseException::class:
                if ($exception->hasResponse()) {
                    throw HttpBadResponseException::badResponseException($exception, $exception->getResponse());
                }
                // Guzzle misclassifies curl exception as a client exception (so there is no response)
                throw HttpClientException::genericRequestException($exception);
            case RequestException::class:
                throw HttpRequestException::requestException($exception);
            case Exception::class:
                throw HttpClientException::genericRequestException($exception);
        }
    }
}
