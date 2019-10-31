<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Vps\IpAddress;
use Transip\Api\Client\Repository\ApiRepository;

class IpAddressRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vps'];
    }

    /**
     * @param string $vpsName
     * @return IpAddress[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $ipAddresses      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($vpsName) . '/ip-addresses');
        $ipAddressesArray = $response['ipAddresses'] ?? [];

        foreach ($ipAddressesArray as $ipAddressArray) {
            $ipAddresses[] = new IpAddress($ipAddressArray);
        }

        return $ipAddresses;
    }

    public function getByVpsNameAddress(string $vpsName, string $ipAddress): ?IpAddress
    {
        $response  = $this->httpClient->get($this->getResourceUrl($vpsName) . '/ip-addresses/' . $ipAddress);
        $ipAddress = $response['ipAddress'] ?? null;

        if ($ipAddress !== null) {
            $ipAddress = new IpAddress($ipAddress);
        }

        return $ipAddress;
    }

    public function update(string $vpsName, IpAddress $ipAddress): void
    {
        $url = $this->getResourceUrl($vpsName). '/ip-addresses/' . $ipAddress->getAddress();
        $this->httpClient->put($url, ['ipAddress' => $ipAddress]);
    }

    public function addIpv6Address(string $vpsName, string $ipv6Address): void
    {
        $url = $this->getResourceUrl($vpsName). '/ip-addresses';
        $this->httpClient->post($url, ['ipAddress' => $ipv6Address]);
    }

    public function removeIpv6Address(string $vpsName, string $ipv6Address): void
    {
        $url = $this->getResourceUrl($vpsName). '/ip-addresses/' . $ipv6Address;
        $this->httpClient->delete($url, []);
    }
}
