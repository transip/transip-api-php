<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Tld;

class DomainTldRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'tlds';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Tld[]
     */
    public function getAll(): array
    {
        $tlds      = [];
        $response  = $this->httpClient->get($this->getResourceUrl());
        $tldsArray = $response['tlds'] ?? [];

        foreach ($tldsArray as $tldArray) {
            $tlds[] = new Tld($tldArray);
        }

        return $tlds;
    }

    public function getByTld(string $tld): Tld
    {
        $response = $this->httpClient->get($this->getResourceUrl($tld));
        $tldArray = $response['tld'] ?? null;
        return new Tld($tldArray);
    }
}
