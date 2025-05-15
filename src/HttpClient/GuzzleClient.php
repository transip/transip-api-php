<?php

namespace Transip\Api\Library\HttpClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Exception\ApiException;
use Transip\Api\Library\Exception\HttpClientException;
use Transip\Api\Library\Exception\HttpRequest\AccessTokenException;
use Transip\Api\Library\Exception\HttpRequestException;
use Transip\Api\Library\Exception\HttpBadResponseException;
use Transip\Api\Library\HttpClient\Middleware\TokenAuthorization;

/**
 * @deprecated This client is deprecated in favour of HttpMethodsClient which supports more client libraries
 * @see HttpMethodsClient
 */
class GuzzleClient extends HttpClient
{
    /**
     * @var Client $client
     */
    private $client;

    public function __construct(string $endpoint, ?Client $client = null)
    {
        $this->client = $client ?? new Client();
        parent::__construct($endpoint);
    }

    public function setToken(string $token): void
    {
        /** @var HandlerStack $stack */
        $stack = $this->client->getConfig('handler') ?? HandlerStack::create();

        $stack->remove(TokenAuthorization::HANDLER_NAME);
        $stack->push(new TokenAuthorization($token, self::USER_AGENT), TokenAuthorization::HANDLER_NAME);

        $this->token = $token;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed[]  $options
     * @return ResponseInterface
     */
    private function sendRequest(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            return $this->request($method, $uri, $options);
        } catch (AccessTokenException $exception) {
            $this->clearCache();
            $this->setToken('');
            return $this->request($method, $uri, $options);
        }
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed[]  $options
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return ResponseInterface
     */
    private function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        $this->checkAndRenewToken();
        $options = $this->checkAndSetTestModeToOptions($options);

        try {
            return $this->client->request($method, "{$this->endpoint}{$uri}", $options);
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @param string $uri
     * @param mixed[] $query
     * @return mixed[]
     */
    public function get(string $uri, array $query = []): array
    {
        $response = $this->sendRequest('GET', $uri, ['query' => $query]);

        if ($response->getStatusCode() !== 200) {
            throw ApiException::unexpectedStatusCode($response);
        }

        if (!(string)$response->getBody()) {
            throw ApiException::emptyResponse($response);
        }

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody === null) {
            throw ApiException::malformedJsonResponse($response);
        }

        $this->parseResponseHeaders($response);

        return $responseBody;
    }

    /**
     * @param string $uri
     * @param mixed[] $body
     * @return ResponseInterface
     */
    public function post(string $uri, array $body = []): ResponseInterface
    {
        $options['body'] = json_encode($body);

        $response = $this->sendRequest('POST', $uri, $options);

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);

        return $response;
    }

    /**
     * @param string $uri
     * @param mixed[] $body
     * @return mixed[]
     */
    public function postWithResponse(string $uri, array $body = []): array
    {
        $options['body'] = json_encode($body);

        $response = $this->sendRequest('POST', $uri, $options);

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }

        if (!(string)$response->getBody()) {
            throw ApiException::expectedBodyFromPost($response);
        }

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody === null) {
            throw ApiException::malformedJsonResponse($response);
        }

        $this->parseResponseHeaders($response);

        return $responseBody;
    }

    /**
     * @param string $uri
     * @param string $signature
     * @param mixed[] $body
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed[]
     */
    public function postAuthentication(string $uri, string $signature, array $body): array
    {
        $options['headers'] = ['Signature' => $signature];
        $options['body']    = json_encode($body);

        try {
            $response = $this->client->post("{$this->endpoint}{$uri}", $options);
        } catch (Exception $exception) {
            $this->handleException($exception);
        }

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }

        if (!(string)$response->getBody()) {
            throw ApiException::emptyResponse($response);
        }

        $responseBody = json_decode($response->getBody(), true);

        if ($responseBody === null) {
            throw ApiException::malformedJsonResponse($response);
        }

        return $responseBody;
    }

    /**
     * @param string $uri
     * @param mixed[] $body
     * @return ResponseInterface
     */
    public function put(string $uri, array $body): ResponseInterface
    {
        $options['body'] = json_encode($body);

        $response = $this->sendRequest('PUT', $uri, $options);

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);

        return $response;
    }

    /**
     * @param string $uri
     * @param mixed[] $body
     * @return ResponseInterface
     */
    public function patch(string $uri, array $body): ResponseInterface
    {
        $options['body'] = json_encode($body);

        $response = $this->sendRequest('PATCH', $uri, $options);

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);

        return $response;
    }

    /**
     * @param string $uri
     * @param mixed[] $body
     * @return void
     */
    public function delete(string $uri, array $body = []): void
    {
        $options['body'] = json_encode($body);

        $response = $this->sendRequest('DELETE', $uri, $options);

        if ($response->getStatusCode() !== 204) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $this->parseResponseHeaders($response);
    }

    /**
     * @param Exception $exception
     * @throws \RuntimeException
     * @return never
     */
    private function handleException(Exception $exception): void
    {
        if ($exception instanceof BadResponseException) {
            if ($exception->hasResponse()) {
                throw HttpBadResponseException::badResponseException($exception, $exception->getResponse());
            }
            // Guzzle misclassifies curl exception as a client exception (so there is no response)
            throw HttpClientException::genericRequestException($exception);
        }

        if ($exception instanceof RequestException) {
            throw HttpRequestException::requestException($exception);
        }

        throw HttpClientException::genericRequestException($exception);
    }

    /**
     * @param mixed[] $options
     * @return mixed[]
     */
    private function checkAndSetTestModeToOptions(array $options): array
    {
        if (!$this->testMode) {
            return $options;
        }

        if (!array_key_exists('query', $options)) {
            $options['query'] = [];
        }

        $options['query']['test'] = 1;

        return $options;
    }
}
