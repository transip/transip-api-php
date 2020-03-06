<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\PrivateNetwork;

class PrivateNetworkRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'private-networks';

    /**
     * @return PrivateNetwork[]
     */
    public function getAll(): array
    {
        $privateNetworks      = [];
        $response             = $this->httpClient->get($this->getResourceUrl());
        $privateNetworksArray = $this->getParameterFromResponse($response, 'privateNetworks');

        foreach ($privateNetworksArray as $privateNetworkArray) {
            $privateNetworks[] = new PrivateNetwork($privateNetworkArray);
        }

        return $privateNetworks;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return PrivateNetwork[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $privateNetworks      = [];
        $query                = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response             = $this->httpClient->get($this->getResourceUrl(), $query);
        $privateNetworksArray = $this->getParameterFromResponse($response, 'privateNetworks');

        foreach ($privateNetworksArray as $privateNetworkArray) {
            $privateNetworks[] = new PrivateNetwork($privateNetworkArray);
        }

        return $privateNetworks;
    }

    /**
     * @param string $description
     * @return PrivateNetwork[]
     */
    public function findByDescription(string $description): array
    {
        $privateNetworks = [];
        foreach ($this->getAll() as $privateNetwork) {
            if ($privateNetwork->getDescription() === $description) {
                $privateNetworks[] = $privateNetwork;
            }
        }

        return $privateNetworks;
    }

    public function getByName(string $privateNetworkName): PrivateNetwork
    {
        $response       = $this->httpClient->get($this->getResourceUrl($privateNetworkName));
        $privateNetwork = $this->getParameterFromResponse($response, 'privateNetwork');

        return new PrivateNetwork($privateNetwork);
    }

    public function order(string $description = ''): void
    {
        $parameters = [];
        if ($description) {
            $parameters['description'] = $description;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(PrivateNetwork $privateNetwork): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($privateNetwork->getName()),
            ['privateNetwork' => $privateNetwork]
        );
    }

    public function attachVps(string $privateNetworkName, string $vpsName): void
    {
        $parameters['action']  = 'attachvps';
        $parameters['vpsName'] = $vpsName;
        $this->httpClient->patch($this->getResourceUrl($privateNetworkName), $parameters);
    }

    public function detachVps(string $privateNetworkName, string $vpsName): void
    {
        $parameters['action']  = 'detachvps';
        $parameters['vpsName'] = $vpsName;
        $this->httpClient->patch($this->getResourceUrl($privateNetworkName), $parameters);
    }

    public function cancel(string $vpsName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName), ['endTime' => $endTime]);
    }
}
