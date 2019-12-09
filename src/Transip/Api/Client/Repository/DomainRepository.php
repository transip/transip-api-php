<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Domain;
use Transip\Api\Client\Entity\Domain\DnsEntry;
use Transip\Api\Client\Entity\Domain\Nameserver;
use Transip\Api\Client\Entity\Domain\WhoisContact;

class DomainRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'domains';

    /**
     * @return Domain[]
     */
    public function getAll(): array
    {
        $domains      = [];
        $response     = $this->httpClient->get($this->getResourceUrl());
        $domainsArray = $response['domains'] ?? [];

        foreach ($domainsArray as $domainArray) {
            $domains[] = new Domain($domainArray);
        }

        return $domains;
    }

    public function getByName(string $name): Domain
    {
        $response = $this->httpClient->get($this->getResourceUrl($name));
        $domain      = $response['domain'] ?? null;
        return new Domain($domain);
    }

    /**
     * @param string         $domainName
     * @param WhoisContact[] $contacts optional
     * @param Nameserver[]   $nameservers optional
     * @param DnsEntry[]     $dnsEntries optional
     */
    public function register(
        string $domainName,
        array $contacts = [],
        array $nameservers = [],
        array $dnsEntries = []
    ): void {
        $parameters = [
            'domainName'  => $domainName,
            'contacts'    => $contacts,
            'nameservers' => $nameservers,
            'dnsEntries'  => $dnsEntries,
        ];
        $this->httpClient->post($this->getResourceUrl(),$parameters);
    }

    /**
     * @param string         $domainName
     * @param string         $authCode
     * @param WhoisContact[] $contacts optional
     * @param Nameserver[]   $nameservers optional
     * @param DnsEntry[]     $dnsEntries optional
     */
    public function transfer(
        string $domainName,
        string $authCode,
        array $contacts = [],
        array $nameservers = [],
        array $dnsEntries = []
    ): void {
        $parameters = [
            'domainName'  => $domainName,
            'authCode'    => $authCode,
            'contacts'    => $contacts,
            'nameservers' => $nameservers,
            'dnsEntries'  => $dnsEntries,
        ];
        $this->httpClient->post($this->getResourceUrl(),$parameters);
    }

    public function update(Domain $domain): void
    {
        $this->httpClient->put($this->getResourceUrl($domain->getName()), ['domain' => $domain]);
    }

    public function cancel(string $domainName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($domainName), ['endTime' => $endTime]);
    }
}
