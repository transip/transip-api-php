<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Repository\ApiRepository;

class ZoneFileRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'zone-file'];
    }

    public function getByDomainName(string $domainName): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $zoneFile = $response['zoneFile'] ?? '';
        return $zoneFile;
    }

    public function update(string $domainName, string $zoneFile): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['zoneFile' => $zoneFile]);
    }
}
