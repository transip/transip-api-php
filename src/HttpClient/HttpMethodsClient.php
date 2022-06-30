<?php

declare(strict_types=1);

namespace Transip\Api\Library\HttpClient;

use Exception;
use Http\Client\Common\Plugin;
use Http\Client\Exception\RequestException;
use Http\Discovery\Psr17FactoryDiscovery;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Transip\Api\Library\Exception\ApiException;
use Transip\Api\Library\Exception\HttpBadResponseException;
use Transip\Api\Library\Exception\HttpClientException;
use Transip\Api\Library\Exception\HttpRequest\BadResponseException;
use Transip\Api\Library\Exception\HttpRequestException;
use Transip\Api\Library\HttpClient\Builder\ClientBuilderInterface;
use Transip\Api\Library\HttpClient\Plugin\ExceptionThrowerPlugin;
use Transip\Api\Library\HttpClient\Plugin\TokenAuthenticationPlugin;
use Transip\Api\Library\TransipAPI;

use function count;
use function http_build_query;
use function json_decode;
use function json_encode;
use function json_last_error;
use function strpos;

use const JSON_ERROR_NONE;

final class HttpMethodsClient extends HttpClient
{
    /**
     * @var ClientBuilderInterface
     */
    private $client;

    public function __construct(
        ClientBuilderInterface $httpClientBuilder,
        ?string $endpoint = null
    ) {
        parent::__construct($endpoint ?? TransipAPI::TRANSIP_API_ENDPOINT);
        $this->client = $httpClientBuilder;

        $this->setupHttpBuilder();
    }

    private function setupHttpBuilder(): void
    {
        $this->client->addPlugin(new ExceptionThrowerPlugin());
        $this->setEndpoint($this->endpoint);
    }

    public function setEndpoint(string $endpoint): void
    {
        // Construct URI
        $uri = Psr17FactoryDiscovery::findUriFactory()->createUri($endpoint);

        // Remove BaseUriPlugin
        $this->client->removePlugin(Plugin\BaseUriPlugin::class);

        // Add new BaseUriPlugin
        $this->client->addPlugin(new Plugin\BaseUriPlugin($uri));
    }

    /**
     * Set authentication token.
     */
    public function setToken(string $token): void
    {
        $this->token = $token;

        // Remove any generic authentication plugin
        $this->client->removePlugin(TokenAuthenticationPlugin::class);

        // Add new Authentication plugin
        $this->client->addPlugin(new TokenAuthenticationPlugin($token));
    }

    /**
     * @param array<mixed, mixed> $query
     *
     * @return array<mixed, mixed>
     */
    public function get(string $url, array $query = []): array
    {
        $this->checkAndRenewToken();

        if (count($query) > 0) {
            $url .= '?' . http_build_query($query);
        }

        $response = $this->getContent(
            $this->client->getHttpClient()->get($url)
        );

        if (is_string($response)) {
            throw new \RuntimeException('Returned data could not be json encoded.');
        }

        return $response;
    }

    /**
     * @param array<mixed, mixed> $body
     */
    public function post(string $url, array $body = []): void
    {
        $this->checkAndRenewToken();
        $this->client->getHttpClient()->post($url, [], $this->createBody($body));
    }

    /**
     * @param array<mixed, mixed> $body
     *
     * @return array<mixed, mixed>
     */
    public function postWithResponse(string $url, array $body = []): array
    {
        $this->checkAndRenewToken();

        $response = $this->client->getHttpClient()->post($url, [], $this->createBody($body));

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }

        $content = $this->getContent($response);

        if (is_string($content)) {
            throw ApiException::expectedBodyFromPost($response);
        }

        return $content;
    }


    /**
     * @param array<mixed, mixed> $body
     *
     * @return array<mixed, mixed>
     */
    public function postAuthentication(string $url, string $signature, array $body): array
    {
        try {
            $response = $this->client->getHttpClient()->post(
                $url,
                ['Signature' => $signature],
                (string)json_encode($body)
            );
        } catch (Exception $exception) {
            $this->handleException($exception);
        }

        if (! isset($response)) {
            throw new LogicException('Variable $response is not defined.');
        }

        if ($response->getStatusCode() !== 201) {
            throw ApiException::unexpectedStatusCode($response);
        }

        if ($response->getBody()->getSize() === 0) {
            throw ApiException::emptyResponse($response);
        }

        $responseBody = json_decode(
            (string)$response->getBody(),
            true
        );

        if ($responseBody === null) {
            throw ApiException::malformedJsonResponse($response);
        }

        return $responseBody;
    }

    /**
     * @param array<mixed, mixed> $body
     */
    public function put(string $url, array $body): void
    {
        $this->checkAndRenewToken();
        $this->client->getHttpClient()->put($url, [], $this->createBody($body));
    }

    /**
     * @param array<mixed, mixed> $body
     */
    public function patch(string $url, array $body): void
    {
        $this->checkAndRenewToken();
        $this->client->getHttpClient()->patch($url, [], $this->createBody($body));
    }

    /**
     * @param array<mixed, mixed> $body
     */
    public function delete(string $url, array $body = []): void
    {
        $this->checkAndRenewToken();
        $this->client->getHttpClient()->delete($url, [], $this->createBody($body));
    }

    /**
     * Tries to decode JSON object returned from server. If response is not of type `application/json` or the JSON can
     * not be decoded, the original data will be returned
     *
     * @return array<mixed, mixed>|string
     */
    private function getContent(ResponseInterface $response)
    {
        $body = (string) $response->getBody();
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $content = json_decode($body, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $content;
            }
        }

        return $body;
    }

    /**
     * @param array<mixed, mixed> $data
     */
    private function createBody(array $data): string
    {
        return (string) json_encode($data);
    }

    private function handleException(Exception $exception): void
    {
        if ($exception instanceof BadResponseException) {
            throw HttpBadResponseException::badResponseException($exception, $exception->getResponse());
        }

        if ($exception instanceof RequestException) {
            throw HttpRequestException::requestException($exception);
        }

        throw HttpClientException::genericRequestException($exception);
    }
}
