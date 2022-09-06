<?php

namespace Transip\Api\Library\Repository\Domain\Tld;

use Transip\Api\Library\Entity\Domain\Tld\AdditionalContactField;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainTldRepository;

class AdditionalContactFieldRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'additionalContactFields';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainTldRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return AdditionalContactField[]
     */
    public function getForTld(string $tld): array
    {
        $response = $this->httpClient->get($this->getResourceUrl($tld));
        $fields   = $this->getParameterFromResponse($response, 'additional-contact-fields');

        return  array_map([new AdditionalContactField(), 'fromArray'], $fields);
    }

    /**
     * @return AdditionalContactField[]
     */
    public function getByDomainName(string $domainName): array
    {
        $domainParts = explode('.', $domainName, 2);
        $tld = sprintf('.%s', $domainParts[1] ?? '');

        return $this->getForTld($tld);
    }
}
