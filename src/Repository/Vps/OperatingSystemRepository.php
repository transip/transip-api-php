<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\OperatingSystem;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class OperatingSystemRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'operating-systems';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return OperatingSystem[]
     */
    public function getAll(): array
    {
        $operatingSystems      = [];
        $response              = $this->httpClient->get($this->getResourceUrl('placeholder'));
        $operatingSystemsArray = $this->getParameterFromResponse($response, 'operatingSystems');

        foreach ($operatingSystemsArray as $operatingSystemArray) {
            $operatingSystems[] = new OperatingSystem($operatingSystemArray);
        }

        return $operatingSystems;
    }

    /**
     * @param string $vpsName
     * @return OperatingSystem[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $operatingSystems      = [];
        $response              = $this->httpClient->get($this->getResourceUrl($vpsName));
        $operatingSystemsArray = $this->getParameterFromResponse($response, 'operatingSystems');

        foreach ($operatingSystemsArray as $operatingSystemArray) {
            $operatingSystems[] = new OperatingSystem($operatingSystemArray);
        }

        return $operatingSystems;
    }

    /**
     * @param string   $vpsName
     * @param string   $operatingSystemName
     * @param string   $hostname
     * @param string   $base64InstallText
     * @param string   $installFlavour
     * @param string   $username
     * @param string[] $sshKeys
     */
    public function install(
        string $vpsName,
        string $operatingSystemName,
        string $hostname = '',
        string $base64InstallText = '',
        string $installFlavour = '',
        string $username = '',
        array $sshKeys = []
    ): void {
        $parameters['operatingSystemName'] = $operatingSystemName;
        $parameters['hostname']            = $hostname;
        $parameters['base64InstallText']   = $base64InstallText;
        $parameters['installFlavour']      = $installFlavour;
        $parameters['username']            = $username;
        $parameters['sshKeys']             = $sshKeys;
        $this->httpClient->post($this->getResourceUrl($vpsName), $parameters);
    }
}
