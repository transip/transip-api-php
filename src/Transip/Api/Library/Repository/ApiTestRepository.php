<?php

namespace Transip\Api\Library\Repository;

class ApiTestRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'api-test';

    public function test(): bool
    {
        $response = $this->httpClient->get($this->getResourceUrl());
        $ping     = $response['ping'] ?? false;
        return $ping === 'pong';
    }
}
