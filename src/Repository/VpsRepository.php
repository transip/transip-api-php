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
     * @param int $page
     * @param int $itemsPerPage
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

    public function getByTagNames(array $tags): array
    {
        $tags      = implode(',', $tags);
        $query     = ['tags' => $tags];
        $response  = $this->httpClient->get($this->getResourceUrl(), $query);
        $vpssArray = $this->getParameterFromResponse($response, 'vpss');

        $vpss = [];
        foreach ($vpssArray as $vpsArray) {
            $vpss[] = new Vps($vpsArray);
        }

        return $vpss;
    }

    /**
     * @param string   $productName
     * @param string   $operatingSystemName
     * @param array    $addons
     * @param string   $hostname
     * @param string   $availabilityZone
     * @param string   $description
     * @param string   $base64InstallText
     * @param string   $installFlavour
     * @param string   $username
     * @param string[] $sshKeys
     */
    public function order(
        string $productName,
        string $operatingSystemName,
        array $addons = [],
        string $hostname = '',
        string $availabilityZone = '',
        string $description = '',
        string $base64InstallText = '',
        string $installFlavour = '',
        string $username = '',
        array $sshKeys = []
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
        if ($installFlavour !== '') {
            $parameters['installFlavour'] = $installFlavour;
        }
        if ($username !== '') {
            $parameters['username'] = $username;
        }
        if ($sshKeys !== '') {
            $parameters['sshKeys'] = $sshKeys;
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
                'description'      => "loadbalancer0",
                'installFlavour'   => "cloudinit",
                'username'         => "kevin",
                'sshKeys'          => ["ssh-rsa AAAAB3NzaC1yc2EAAA..."],
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
