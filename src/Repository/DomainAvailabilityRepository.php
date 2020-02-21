<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\DomainCheckResult;

class DomainAvailabilityRepository extends ApiRepository
{
    protected const RESOURCE_NAME = 'domain-availability';

    public function checkDomainName(string $domainName): DomainCheckResult
    {
        $response          = $this->httpClient->get($this->getResourceUrl($domainName));
        $domainCheckResult = $this->getParameterFromResponse($response, 'availability');

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
        $domainCheckArray   = $this->getParameterFromResponse($response, 'availability');

        foreach ($domainCheckArray as $domainArray) {
            $domainCheckResults[] = new DomainCheckResult($domainArray);
        }

        return $domainCheckResults;
    }
}
