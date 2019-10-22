<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\HttpClient\HttpClientInterface;

abstract class ApiRepository
{
    /**
     * @var HttpClientInterface $httpClient
     */
    protected $httpClient;

    /**
     * @var string $endpoint
     */
    protected $endpoint;

    /**
     * @var string $repositoryEndpoint
     */
    protected $repositoryEndpoint = '';

    /**
     * @param HttpClientInterface $httpClient
     * @param string              $endpoint
     */
    public function __construct(HttpClientInterface $httpClient, string $endpoint)
    {
        $this->httpClient = $httpClient;
        // make sure endpoint always ends with one trailing forward slash
        $endpoint = rtrim($endpoint, '/') . '/';
        $this->endpoint   = $endpoint . $this->repositoryEndpoint;
    }
}
