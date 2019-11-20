<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Vps;

class VpsRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vpses'];
    }

    /**
     * @return Vps[]
     */
    public function getAll(): array
    {
        $vpses      = [];
        $response   = $this->httpClient->get($this->getResourceUrl());
        $vpsesArray = $response['vpses'] ?? [];

        foreach ($vpsesArray as $vpsArray) {
            $vpses[] = new Vps($vpsArray);
        }

        return $vpses;
    }

    public function getByName(string $name): Vps
    {
        $response = $this->httpClient->get($this->getResourceUrl($name));
        $vps      = $response['vps'] ?? null;
        return new Vps($vps);
    }

    public function order(
        string $productName,
        string $operatingSystemName,
        array $addons = [],
        string $hostname = '',
        string $availabilityZone = ''
    ): void {
        $parameters['productName']     = $productName;
        $parameters['operatingSystem'] = $operatingSystemName;

        if (!empty($addons)) {
            $parameters['addons'] = $addons;
        }
        if ($hostname !== '') {
            $parameters['hostname'] = $hostname;
        }
        if ($availabilityZone !== '') {
            $parameters['availabilityZone'] = $availabilityZone;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function cloneVps(string $vpsName, string $availabilityZone = ''): void
    {
        $parameters['vpsName'] = $vpsName;
        if ($availabilityZone !== '') {
            $parameters['availabilityZone'] = $availabilityZone;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(Vps $vps): void
    {
        $this->httpClient->put($this->getResourceUrl($vps->getName()), ['vps' => $vps]);
    }

    public function start(string $vpsName): void
    {
        $this->httpClient->patch($this->getResourceUrl($vpsName), ['action' => 'start']);
    }

    public function stop(string $vpsName): void
    {
        $this->httpClient->patch($this->getResourceUrl($vpsName), ['action' => 'stop']);
    }

    public function reset(string $vpsName): void
    {
        $this->httpClient->patch($this->getResourceUrl($vpsName), ['action' => 'reset']);
    }

    public function cancel(string $vpsName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName), ['endTime' => $endTime]);
    }
}
