<?php

namespace Transip\Api\Library\Repository;

class DomainWhitelabelRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'whitelabel';

    public function order(): void
    {
        $this->httpClient->post($this->getResourceUrl());
    }
}
