<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Vps\OperatingSystem;
use Transip\Api\Client\Repository\ApiRepository;

class OperatingSystemRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vps', 'operating-systems'];
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
