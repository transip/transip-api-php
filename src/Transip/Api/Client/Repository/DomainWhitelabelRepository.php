<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Tld;

class DomainWhitelabelRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['whitelabel'];
    }

    public function order(): void
    {
        $this->httpClient->post($this->getResourceUrl(), []);
    }
}
