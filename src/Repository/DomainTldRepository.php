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

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return Tld[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $tlds     = [];
        $query    = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response = $this->httpClient->get($this->getResourceUrl(), $query);
        $tldList  = $this->getParameterFromResponse($response, 'tlds');


        foreach ($tldList as $tld) {
            $tlds[] = new Tld($tld);
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
