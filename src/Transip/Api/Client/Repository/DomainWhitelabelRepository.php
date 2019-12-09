<?php

namespace Transip\Api\Client\Repository;

class DomainWhitelabelRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'whitelabel';

    public function order(): void
    {
        $this->httpClient->post($this->getResourceUrl());
    }
}
