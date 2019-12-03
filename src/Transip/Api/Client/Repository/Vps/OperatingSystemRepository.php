<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Vps\OperatingSystem;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\VpsRepository;

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
        $operatingSystemsArray = $response['operatingSystems'] ?? [];

        foreach ($operatingSystemsArray as $operatingSystemArray) {
            $operatingSystems[] = new OperatingSystem($operatingSystemArray);
        }

        return $operatingSystems;
    }

    public function install(
        string $vpsName,
        string $operatingSystemName,
        string $hostname = '',
        string $base64InstallText = ''
    ): void {
        $parameters['operatingSystemName'] = $operatingSystemName;
        $parameters['hostname']            = $hostname;
        $parameters['base64InstallText']   = $base64InstallText;
        $this->httpClient->post($this->getResourceUrl($vpsName), $parameters);
    }
}
