<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\Domain\Nameserver;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class NameserverRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'nameservers';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return Nameserver[]
     */
    public function getByDomainName(string $domainName): array
    {
        $nameservers      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($domainName));
        $nameserversArray = $this->getParameterFromResponse($response, 'nameservers');

        foreach ($nameserversArray as $nameserverArray) {
            $nameservers[] = new Nameserver($nameserverArray);
        }

        return $nameservers;
    }

    /**
     * @param string       $domainName
     * @param Nameserver[] $nameservers
     */
    public function update(string $domainName, array $nameservers): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['nameservers' => $nameservers]);
    }
}
