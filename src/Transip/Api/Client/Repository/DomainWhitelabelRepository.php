<?php

namespace Transip\Api\Client\Repository;

class DomainWhitelabelRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'whitelabel';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    public function order(): void
    {
        $this->httpClient->post($this->getResourceUrl());
    }
}
