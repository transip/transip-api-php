<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class ZoneFileRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'zone-file';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByDomainName(string $domainName): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $zoneFile = $this->getParameterFromResponse($response, 'zoneFile');

        return $zoneFile;
    }

    public function update(string $domainName, string $zoneFile): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['zoneFile' => $zoneFile]);
    }
}