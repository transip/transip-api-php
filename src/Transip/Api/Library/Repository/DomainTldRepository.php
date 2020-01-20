<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Tld;

class DomainTldRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'tlds';

    /**
     * @return Tld[]
     */
    public function getAll(): array
    {
        $tlds      = [];
        $response  = $this->httpClient->get($this->getResourceUrl());
        $tldsArray = $this->getParameterFromResponse($response, 'tlds');

        foreach ($tldsArray as $tldArray) {
            $tlds[] = new Tld($tldArray);
        }

        return $tlds;
    }

    public function getByTld(string $tld): Tld
    {
        $response = $this->httpClient->get($this->getResourceUrl($tld));
        $tldArray = $this->getParameterFromResponse($response, 'tld');

        return new Tld($tldArray);
    }
}
