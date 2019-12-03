<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\DomainCheckResult;

class DomainAvailabilityRepository extends ApiRepository
{
    protected const RESOURCE_NAME = 'domain-availability';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    public function checkDomainName(string $domainName): DomainCheckResult
    {
        $response          = $this->httpClient->get($this->getResourceUrl($domainName));
        $domainCheckResult = $response['availability'] ?? null;
        return new DomainCheckResult($domainCheckResult);
    }
}
