<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\Domain\DnsSecEntry;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class DnsSecRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'dnssec';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return DnsSecEntry[]
     */
    public function getByDomainName(string $domainName): array
    {
        $dnssecEntries      = [];
        $response           = $this->httpClient->get($this->getResourceUrl($domainName));
        $dnssecEntriesArray = $this->getParameterFromResponse($response, 'dnsSecEntries');

        foreach ($dnssecEntriesArray as $dnssecEntryArray) {
            $dnssecEntries[] = new DnsSecEntry($dnssecEntryArray);
        }

        return $dnssecEntries;
    }

    /**
     * @param string        $domainName
     * @param DnsSecEntry[] $dnsSecEntries
     */
    public function update(string $domainName, array $dnsSecEntries): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['dnsSecEntries' => $dnsSecEntries]);
    }
}
