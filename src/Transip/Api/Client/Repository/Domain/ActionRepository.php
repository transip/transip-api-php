<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\DnsEntry;
use Transip\Api\Client\Entity\Domain\Nameserver;
use Transip\Api\Client\Entity\Domain\WhoisContact;
use Transip\Api\Client\Entity\Domain\Action;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\DomainRepository;

class ActionRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'actions';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
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
