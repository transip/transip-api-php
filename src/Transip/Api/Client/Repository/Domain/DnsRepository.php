<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\DnsEntry;
use Transip\Api\Client\Repository\ApiRepository;

class DnsRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'dns'];
    }

    /**
     * @param string $domainName
     * @return DnsEntry[]
     */
    public function getByDomainName(string $domainName): array
    {
        $response        = $this->httpClient->get($this->getResourceUrl($domainName));
        $dnsEntriesArray = $response['dnsEntries'] ?? null;
        $dnsEntries      = [];

        foreach ($dnsEntriesArray as $dnsEntryArray) {
            $dnsEntries[] = new DnsEntry($dnsEntryArray);
        }

        return $dnsEntries;
    }

    public function addDnsEntryToDomain(string $domainName, DnsEntry $dnsEntry)
    {
        $this->httpClient->post($this->getResourceUrl($domainName), ['dnsEntry' => $dnsEntry]);
    }

    public function updateEntry(string $domainName, DnsEntry $dnsEntry): void
    {
        $this->httpClient->patch($this->getResourceUrl($domainName), ['dnsEntry' => $dnsEntry]);
    }

    public function update(string $domainName, array $dnsEntries): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['dnsEntries' => $dnsEntries]);
    }

    public function removeDnsEntry(string $domainName, DnsEntry $dnsEntry): void
    {
        $this->httpClient->delete($this->getResourceUrl($domainName), ['dnsEntry' => $dnsEntry]);
    }
}
