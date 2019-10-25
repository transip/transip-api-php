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
    private $endpoint;

    public function __construct(HttpClientInterface $httpClient, string $endpoint)
    {
        $endpoint         = rtrim($endpoint, '/');
        $this->httpClient = $httpClient;
        $this->endpoint   = $endpoint;
    }

    protected function getResourceUrl(...$args): string
    {
        $urlSuffix     = '';
        $resourceNames = $this->getRepositoryResourceNames();
        while (($resourceName = array_shift($resourceNames)) !== null) {
            $id        = array_shift($args);
            $urlSuffix .= "/{$resourceName}";
            if ($id !== null) {
                $urlSuffix .= "/{$id}";
            }
        }
        return "{$this->endpoint}{$urlSuffix}";
    }

    abstract protected function getRepositoryResourceNames(): array;
}
