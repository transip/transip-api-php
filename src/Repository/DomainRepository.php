<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Domain;
use Transip\Api\Library\Entity\Domain\DnsEntry;
use Transip\Api\Library\Entity\Domain\Nameserver;
use Transip\Api\Library\Entity\Domain\WhoisContact;

class DomainRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'domains';

    /**
     * @return Domain[]
     */
    public function getAll(array $includes = []): array
    {
        $domains      = [];
        $query = [];
        $query        = $this->addIncludesToQuery($query, $includes);

        $response     = $this->httpClient->get($this->getResourceUrl(), $query);
        $domainsArray = $this->getParameterFromResponse($response, 'domains');

        foreach ($domainsArray as $domainArray) {
            $domains[] = new Domain($domainArray);
        }

        return $domains;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return Domain[]
     */
    public function getSelection(int $page, int $itemsPerPage, array $includes = []): array
    {
        $domains      = [];
        $query        = ['pageSize' => $itemsPerPage, 'page' => $page];
        $query        = $this->addIncludesToQuery($query, $includes);
        $response     = $this->httpClient->get($this->getResourceUrl(), $query);
        $domainsArray = $this->getParameterFromResponse($response, 'domains');

        foreach ($domainsArray as $domainArray) {
            $domains[] = new Domain($domainArray);
        }

        return $domains;
    }

    public function getByName(string $name, array $includes = []): Domain
    {
        $query = $this->addIncludesToQuery([], $includes);
        $response = $this->httpClient->get($this->getResourceUrl($name), $query);

        $domain   = $this->getParameterFromResponse($response, 'domain');

        return new Domain($domain);
    }

    private function addIncludesToQuery(array $query = [], array $includes = [])
    {
        $includeString = implode(',', $includes);

        if ($includeString !== '') {
            $query = array_merge($query, ['include' => $includeString]);
        }

        return $query;
    }

    public function getByTagNames(array $tags): array
    {
        $tags         = implode(',', $tags);
        $query        = ['tags' => $tags];
        $response     = $this->httpClient->get($this->getResourceUrl(), $query);
        $domainsArray = $this->getParameterFromResponse($response, 'domains');

        $domains = [];
        foreach ($domainsArray as $domainArray) {
            $domains[] = new Domain($domainArray);
        }

        return $domains;
    }

    /**
     * @param string         $domainName
     * @param WhoisContact[] $contacts    optional
     * @param Nameserver[]   $nameservers optional
     * @param DnsEntry[]     $dnsEntries  optional
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
        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    /**
     * @param string         $domainName
     * @param string         $authCode
     * @param WhoisContact[] $contacts    optional
     * @param Nameserver[]   $nameservers optional
     * @param DnsEntry[]     $dnsEntries  optional
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
        $this->httpClient->post($this->getResourceUrl(), $parameters);
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
