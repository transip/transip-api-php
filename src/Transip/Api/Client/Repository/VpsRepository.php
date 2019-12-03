<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Vps;

class VpsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'vpss';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Vps[]
     */
    public function getAll(): array
    {
        $vpss      = [];
        $response   = $this->httpClient->get($this->getResourceUrl());
        $vpssArray = $response['vpss'] ?? [];

        foreach ($vpssArray as $vpsArray) {
            $vpss[] = new Vps($vpsArray);
        }

        return $vpss;
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
        string $availabilityZone = '',
        string $description = ''
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
        if ($description !== '') {
            $parameters['description'] = $description;
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

    public function handover(string $vpsName, string $targetCustomerName): void
    {
        $parameters = [
            'action'             => 'handover',
            'targetCustomerName' => $targetCustomerName
        ];
        $this->httpClient->patch($this->getResourceUrl($vpsName), $parameters);
    }

    public function cancel(string $vpsName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName), ['endTime' => $endTime]);
    }
}
