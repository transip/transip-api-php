<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\Firewall;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class FirewallRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'firewall';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

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

    public function reset(string $vpsName): void
    {
        $this->httpClient->patch($this->getResourceUrl($vpsName), ['action' => 'reset']);
    }
}
