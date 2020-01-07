<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\Branding;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\DomainRepository;

class WhoisRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'whois';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByDomainName(string $domainName): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $whois = $this->getParameterFromResponse($response, 'whois');

        return $whois;
    }
}
