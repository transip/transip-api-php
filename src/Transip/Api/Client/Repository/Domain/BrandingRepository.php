<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\Branding;
use Transip\Api\Client\Repository\ApiRepository;

class BrandingRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'branding'];
    }

    public function getByDomainName(string $domainName): Branding
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $branding = $response['branding'] ?? null;
        return new Branding($branding);
    }

    public function update(string $domainName, Branding $branding): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['branding' => $branding]);
    }
}
