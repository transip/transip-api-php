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

    protected function crawlPagination(string $urlToFetch, $keyToStack)
    {
        $returnData = [];
        $nextQueryString = '';

        do {
            $response = $this->httpClient->get($urlToFetch . $nextQueryString);
            $nextQueryString = $this->getNextUrlFromResponse($response);

            foreach ($response[$keyToStack] as $dataToAdd) {
                $returnData[] = $dataToAdd;
            }
        } while ($nextQueryString != '');

        return [$keyToStack => $returnData];
    }

    protected function getNextUrlFromResponse(array $response): ?string
    {
        $links = $response['_links'];

        foreach ($links as $linkData) {
            $linkDataName = $linkData['rel'];

            if ($linkDataName === 'next') {
                list($url, $queryString) = explode('?', $linkData['link']);

                return "?{$queryString}";
            }
        }

        return null;
    }
}
