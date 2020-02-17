<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\Domain\Branding;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class BrandingRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'branding';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByDomainName(string $domainName): Branding
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $branding = $this->getParameterFromResponse($response, 'branding');

        return new Branding($branding);
    }

    public function update(string $domainName, Branding $branding): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['branding' => $branding]);
    }
}
