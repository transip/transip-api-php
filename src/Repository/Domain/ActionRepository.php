<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\Domain\DnsEntry;
use Transip\Api\Library\Entity\Domain\Nameserver;
use Transip\Api\Library\Entity\Domain\WhoisContact;
use Transip\Api\Library\Entity\Domain\Action;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

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
        $action   = $this->getParameterFromResponse($response, 'action');

        return new Action($action);
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
        $this->httpClient->delete($this->getResourceUrl($domainName), []);
    }
}
