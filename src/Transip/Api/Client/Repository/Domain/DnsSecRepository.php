<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\DnsSecEntry;
use Transip\Api\Client\Repository\ApiRepository;

class DnsSecRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'dnssec'];
    }

    /**
     * @param string $domainName
     * @return DnsSecEntry[]
     */
    public function getByDomainName(string $domainName): array
    {
        $dnssecEntries      = [];
        $response           = $this->httpClient->get($this->getResourceUrl($domainName));
        $dnssecEntriesArray = $response['dnsSecEntries'] ?? [];

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
