<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\PrivateNetwork;

class PrivateNetworkRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['private-networks'];
    }

    /**
     * @return PrivateNetwork[]
     */
    public function getAll(): array
    {
        $privateNetworks      = [];
        $response             = $this->httpClient->get($this->getResourceUrl());
        $privateNetworksArray = $response['privateNetworks'] ?? [];

        foreach ($privateNetworksArray as $privateNetworkArray) {
            $privateNetworks[] = new PrivateNetwork($privateNetworkArray);
        }

        return $privateNetworks;
    }

    public function getByName(string $privateNetworkName): PrivateNetwork
    {
        $response       = $this->httpClient->get($this->getResourceUrl($privateNetworkName));
        $privateNetwork = $response['privateNetwork'] ?? null;
        return new PrivateNetwork($privateNetwork);
    }

    public function order(): void
    {
        $this->httpClient->post($this->getResourceUrl(), []);
    }

    public function update(PrivateNetwork $privateNetwork): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($privateNetwork->getName()),
            ['privateNetwork' => $privateNetwork]
        );
    }

    public function addVps(string $privateNetworkName, string $vpsName)
    {
        $parameters['action']  = 'addvps';
        $parameters['vpsName'] = $vpsName;
        $this->httpClient->patch($this->getResourceUrl($privateNetworkName), $parameters);
    }

    public function removeVps(string $privateNetworkName, string $vpsName)
    {
        $parameters['action']  = 'removevps';
        $parameters['vpsName'] = $vpsName;
        $this->httpClient->patch($this->getResourceUrl($privateNetworkName), $parameters);
    }

    public function cancel(string $vpsName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName), ['endTime' => $endTime]);
    }
}
