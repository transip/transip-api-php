<?php

namespace Transip\Api\Client\Repository\Colocation;

use Transip\Api\Client\Entity\Vps\IpAddress;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\ColocationRepository;

class IpAddressRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ip-addresses';

    protected function getRepositoryResourceNames(): array
    {
        return [ColocationRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $coloName
     * @return IpAddress[]
     */
    public function getByColoName(string $coloName): array
    {
        $ipAddresses      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($coloName));
        $ipAddressesArray = $response['ipAddresses'] ?? [];

        foreach ($ipAddressesArray as $ipAddressArray) {
            $ipAddresses[] = new IpAddress($ipAddressArray);
        }

        return $ipAddresses;
    }

    public function getByColoNameAddress(string $coloName, string $ipAddress): IpAddress
    {
        $response  = $this->httpClient->get($this->getResourceUrl($coloName, $ipAddress));
        $ipAddress = $response['ipAddress'] ?? null;
        return new IpAddress($ipAddress);
    }

    public function update(string $coloName, IpAddress $ipAddress): void
    {
        $url = $this->getResourceUrl($coloName,  $ipAddress->getAddress());
        $this->httpClient->put($url, ['ipAddress' => $ipAddress]);
    }

    public function addIpAddress(string $coloName, string $ipAddress, string $reverseDns = ''): void
    {
        $url        = $this->getResourceUrl($coloName, $ipAddress);
        $parameters = [];

        if ($reverseDns !== '') {
            $parameters = ['ipAddress' => ['reverseDns' => $reverseDns]];
        }

        $this->httpClient->post($url, $parameters);
    }

    public function removeAddress(string $coloName, string $ipAddress): void
    {
        $url = $this->getResourceUrl($coloName, $ipAddress);
        $this->httpClient->delete($url);
    }
}
