<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\Domain\DnsEntry;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class DnsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'dns';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return DnsEntry[]
     */
    public function getByDomainName(string $domainName): array
    {
        $dnsEntries      = [];
        $response        = $this->httpClient->get($this->getResourceUrl($domainName));
        $dnsEntriesArray = $this->getParameterFromResponse($response, 'dnsEntries');

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
