<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\Branding;
use Transip\Api\Client\Repository\ApiRepository;

class WhoisRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'whois'];
    }

    public function getByDomainName(string $domainName): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $whois = $response['whois'] ?? null;
        return $whois;
    }
}
