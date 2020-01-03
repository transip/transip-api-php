<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\HttpClient\HttpClientInterface;

abstract class ApiRepository
{
    /**
     * @var HttpClientInterface $httpClient
     */
    protected $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
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
        return $urlSuffix;
    }

    protected function getRepositoryResourceNames(): array
    {
        return [static::RESOURCE_NAME];
    }
}
