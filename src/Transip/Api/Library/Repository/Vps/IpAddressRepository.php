<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\IpAddress;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class IpAddressRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ip-addresses';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return IpAddress[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $ipAddresses      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($vpsName));
        $ipAddressesArray = $this->getParameterFromResponse($response, 'ipAddresses');

        foreach ($ipAddressesArray as $ipAddressArray) {
            $ipAddresses[] = new IpAddress($ipAddressArray);
        }

        return $ipAddresses;
    }

    public function getByVpsNameAddress(string $vpsName, string $ipAddress): IpAddress
    {
        $response  = $this->httpClient->get($this->getResourceUrl($vpsName, $ipAddress));
        $ipAddress = $this->getParameterFromResponse($response, 'ipAddress');

        return new IpAddress($ipAddress);
    }

    public function update(string $vpsName, IpAddress $ipAddress): void
    {
        $url = $this->getResourceUrl($vpsName, $ipAddress->getAddress());
        $this->httpClient->put($url, ['ipAddress' => $ipAddress]);
    }

    public function addIpv6Address(string $vpsName, string $ipv6Address): void
    {
        $url = $this->getResourceUrl($vpsName);
        $this->httpClient->post($url, ['ipAddress' => $ipv6Address]);
    }

    public function removeIpv6Address(string $vpsName, string $ipv6Address): void
    {
        $url = $this->getResourceUrl($vpsName, $ipv6Address);
        $this->httpClient->delete($url);
    }
}
