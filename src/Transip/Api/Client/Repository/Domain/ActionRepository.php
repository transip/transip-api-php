<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\DnsEntry;
use Transip\Api\Client\Entity\Domain\Nameserver;
use Transip\Api\Client\Entity\Domain\WhoisContact;
use Transip\Api\Client\Entity\Domain\Action;
use Transip\Api\Client\Repository\ApiRepository;

class ActionRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'actions'];
    }

    public function getByDomainName(string $domainName): Action
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $vps      = $response['action'] ?? null;
        return new Action($vps);
    }

    /**
     * @param string         $domainName
     * @param string         $authCode
     * @param DnsEntry[]     $dnsEntries
     * @param Nameserver[]   $nameservers
     * @param WhoisContact[] $contacts
     */
    public function retryDomainAction(
        string $domainName,
        string $authCode = '',
        array $dnsEntries = [],
        array $nameservers = [],
        array $contacts = []
    ): void {
        $parameters = [
            'authCode'    => $authCode,
            'dnsEntries'  => $dnsEntries,
            'nameservers' => $nameservers,
            'contacts'    => $contacts,
        ];
        $this->httpClient->patch($this->getResourceUrl($domainName), $parameters);
    }

    public function cancelAction(string $domainName): void
    {
        $this->httpClient->delete($this->getResourceUrl($domainName),[]);
    }
}
