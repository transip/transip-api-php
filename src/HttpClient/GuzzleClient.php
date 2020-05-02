<?php

namespace Transip\Api\Library\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Exception\ApiException;
use Transip\Api\Library\Exception\HttpClientException;
use Transip\Api\Library\Exception\HttpRequest\UnauthorizedException;
use Transip\Api\Library\Exception\HttpRequestException;
use Transip\Api\Library\Exception\HttpBadResponseException;
use Exception;

class GuzzleClient extends HttpClient
{
    /**
     * @var Client $client
     */
    private $client;

    public function __construct(string $endpoint)
    {
        $this->client = new Client();
        parent::__construct($endpoint);
    }

    public function setToken(string $token): void
    {
        $config = [
            'headers' => [
                'Authorization' => "Bearer {$token}",
                'User-Agent' => self::USER_AGENT
            ]
        ];
        $this->client = new Client($config);
        $this->token = $token;
    }

    public function get(string $url, array $query = []): array
    {
        $options = [];
        if (count($query) > 0) {
            $options['query'] = $query;
        }

        $this->checkAndRenewToken();
        $options = $this->checkAndSetTestModeToOptions($options);

        $response = $this->performRequest('get', $url, $options);

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

        $this->parseResponseHeaders($response);

        return $responseBody;
    }

    public function post(string $url, array $body = []): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();
        $options = $this->checkAndSetTestModeToOptions($options);

        $response = $this->performRequest('post', $url, $options);

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);
    }

    public function postAuthentication(string $url, string $signature, array $body): array
    {
        $options['headers'] = ['Signature' => $signature];
        $options['body']    = json_encode($body);

        try {
            $response = $this->client->post("{$this->endpoint}{$url}", $options);
        } catch (Exception $exception) {
            $newException = $this->exceptionHandler($exception);
            throw new $newException;
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
        $options = $this->checkAndSetTestModeToOptions($options);

        $response = $this->performRequest('put', $url, $options);

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);
    }

    public function patch(string $url, array $body): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();
        $options = $this->checkAndSetTestModeToOptions($options);

        $response = $this->performRequest('patch', $url, $options);

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);
    }

    public function delete(string $url, array $body = []): void
    {
        $options['body'] = json_encode($body);

        $this->checkAndRenewToken();
        $options = $this->checkAndSetTestModeToOptions($options);

        $response = $this->performRequest('delete', $url, $options);

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);
    }

    private function exceptionHandler(Exception $exception): Exception
    {
        if ($exception instanceof BadResponseException) {
            if ($exception->hasResponse()) {
                return HttpBadResponseException::badResponseException($exception, $exception->getResponse());
            }
            // Guzzle misclassifies curl exception as a client exception (so there is no response)
            return HttpClientException::genericRequestException($exception);
        }

        if ($exception instanceof RequestException) {
            return HttpRequestException::requestException($exception);
        }

        return HttpClientException::genericRequestException($exception);
    }

    private function performRequest(string $method, string $url, array $options): ?ResponseInterface
    {
        $method = strtolower($method);
        if (!in_array($method, ['get', 'post', 'put', 'delete', 'patch'])) {
            throw new Exception('Invalid HTTP request method');
        }

        $tries = 0;
        $response = null;
        do {
            $tries++;
            try {
                $response = $this->client->{$method}("{$this->endpoint}{$url}", $options);
            } catch (Exception $exception) {
                $exception = $this->exceptionHandler($exception);
                if ($exception instanceof UnauthorizedException &&
                    $exception->getMessage() === 'Your access token has been revoked.') {
                    $this->clearCache();
                    $this->setToken('');
                    $this->checkAndRenewToken();
                } else {
                    throw $exception;
                }
            }
        } while($response === null && $tries < 2);

        return $response;
    }

    private function checkAndSetTestModeToOptions(array $options): array
    {
        if ($this->testMode == false) {
            return $options;
        }

        if (!array_key_exists('query', $options)) {
            $options['query'] = [];
        }

        $options['query']['test'] = 1;

        return $options;
    }
}
