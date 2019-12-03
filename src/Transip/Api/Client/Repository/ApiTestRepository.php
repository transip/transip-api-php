<?php

namespace Transip\Api\Client\Repository;

class ApiTestRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'api-test';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    public function test(): bool
    {
        $response = $this->httpClient->get($this->getResourceUrl());
        $ping     = $response['ping'] ?? false;
        return $ping === 'pong';
    }
}
