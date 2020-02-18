<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Vps;

class VpsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'vps';

    /**
     * @return Vps[]
     */
    public function getAll(): array
    {
        $vpss      = [];
        $response  = $this->httpClient->get($this->getResourceUrl());
        $vpssArray = $this->getParameterFromResponse($response, 'vpss');

        foreach ($vpssArray as $vpsArray) {
            $vpss[] = new Vps($vpsArray);
        }

        return $vpss;
    }

    /**
     * @return Vps[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $vpss      = [];
        $query     = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response  = $this->httpClient->get($this->getResourceUrl(), $query);
        $vpssArray = $this->getParameterFromResponse($response, 'vpss');

        foreach ($vpssArray as $vpsArray) {
            $vpss[] = new Vps($vpsArray);
        }

        return $vpss;
    }

    public function getByName(string $name): Vps
    {
        $response = $this->httpClient->get($this->getResourceUrl($name));
        $vps      = $this->getParameterFromResponse($response, 'vps');

        return new Vps($vps);
    }

    public function order(
        string $productName,
        string $operatingSystemName,
        array $addons = [],
        string $hostname = '',
        string $availabilityZone = '',
        string $description = '',
        string $base64InstallText = ''
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
        if ($base64InstallText !== '') {
            $parameters['base64InstallText'] = $base64InstallText;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    /**
     * Example array with multiple VPSs
     *
        $vpss = [
            [
                'productName'      => "vps-bladevps-x1",
                'operatingSystem'  => "ubuntu-18.04",
                'addons'           => ["vpsAddon-1-extra-cpu-core"],
                'hostname'         => "",
                'availabilityZone' => "rtm0",
                'description'      => "loadbalancer0"
            ],
            [
                'productName'      => "vps-bladevps-x1",
                'operatingSystem'  => "ubuntu-18.04",
                'addons'           => ["vpsAddon-1-extra-cpu-core"],
                'hostname'         => "",
                'availabilityZone' => "ams0",
                'description'      => "loadbalancer1"
            ]
        ];
     *
     * @param array $vpss
     */
    public function orderMultiple(array $vpss): void
    {
        $this->httpClient->post($this->getResourceUrl(), ['vpss' => $vpss]);
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
