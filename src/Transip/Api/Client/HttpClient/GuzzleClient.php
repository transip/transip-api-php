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

    public function post(string $url, array $body = []): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();

        try {
            $response = $this->client->post("{$this->endpoint}{$url}", $options);
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
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
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
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
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
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
        } catch (RequestException $requestException) {
            throw HttpRequestException::requestException($requestException, $requestException->getResponse());
        } catch (Exception $exception) {
            throw HttpClientException::genericRequestException($exception);
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
