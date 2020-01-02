<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\DomainCheckResult;

class DomainAvailabilityRepository extends ApiRepository
{
    protected const RESOURCE_NAME = 'domain-availability';

    public function checkDomainName(string $domainName): DomainCheckResult
    {
        $response          = $this->httpClient->get($this->getResourceUrl($domainName));
        $domainCheckResult = $response['availability'] ?? null;
        return new DomainCheckResult($domainCheckResult);
    }

    /**
     * @param array $domainNames
     * @return DomainCheckResult[]
     */
    public function checkMultipleDomainNames(array $domainNames): array
    {
        $domainCheckResults = [];
        $response           = $this->httpClient->get($this->getResourceUrl(), ['domainNames' => $domainNames]);
        $domainCheckArray   = $response['availability'] ?? [];

        foreach ($domainCheckArray as $domainArray) {
            $domainCheckResults[] = new DomainCheckResult($domainArray);
        }

        return $domainCheckResults;
    }
}
