<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Vps\Firewall;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\VpsRepository;

class FirewallRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'firewall';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return Firewall
     */
    public function getByVpsName(string $vpsName): Firewall
    {
        $response      = $this->httpClient->get($this->getResourceUrl($vpsName));
        $firewallArray = $this->getParameterFromResponse($response, 'vpsFirewall');

        return new Firewall($firewallArray);
    }

    public function update(string $vpsName, Firewall $firewall): void
    {
        $this->httpClient->put($this->getResourceUrl($vpsName), ['vpsFirewall' => $firewall]);
    }
}
