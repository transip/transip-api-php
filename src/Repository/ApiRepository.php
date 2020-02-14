<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Exception\ApiClientException;
use Transip\Api\Library\HttpClient\HttpClientInterface;

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

    /**
     * @param array  $response
     * @param string $parameterName
     * @return mixed
     * @throws ApiClientException
     */
    protected function getParameterFromResponse(array $response, string $parameterName)
    {
        if (!isset($response[$parameterName])) {
            throw ApiClientException::parameterMissingInResponse($response, $parameterName);
        }
        return $response[$parameterName];
    }
}
