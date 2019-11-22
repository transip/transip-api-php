<?php

namespace Transip\Api\Client\Repository\Haip;

use Transip\Api\Client\Entity\Haip\PortConfiguration;
use Transip\Api\Client\Repository\ApiRepository;

class PortConfigurationRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['haips', 'port-configurations'];
    }

    /**
     * @param string $haipName
     * @return PortConfiguration[]
     */
    public function getByHaipName(string $haipName): array
    {
        $portConfigurations = [];
        $response           = $this->httpClient->get($this->getResourceUrl($haipName));
        $portConfigurationArray   = $response['portConfigurations'] ?? [];

        foreach ($portConfigurationArray as $portConfigurationStruct) {
            $portConfigurations[] = new PortConfiguration($portConfigurationStruct);
        }

        return $portConfigurations;
    }

    public function update(string $haipName, PortConfiguration $portConfiguration): void
    {
        $url = $this->getResourceUrl($haipName, $portConfiguration->getId());

        $this->httpClient->put($url, ['portConfiguration' => $portConfiguration]);
    }

    public function delete(string $haipName, int $portConfigurationId): void
    {
        $url = $this->getResourceUrl($haipName, $portConfigurationId);
        $this->httpClient->delete($url, []);
    }

    public function add(string $haipName, PortConfiguration $portConfiguration): void
    {
        $url = $this->getResourceUrl($haipName);

        $requestData = [
            'name'            => $portConfiguration->getName(),
            'sourcePort'      => $portConfiguration->getSourcePort(),
            'targetPort'      => $portConfiguration->getTargetPort(),
            'mode'            => $portConfiguration->getMode(),
            'endpointSslMode' => $portConfiguration->getEndPointSslMode(),
        ];

        $this->httpClient->post($url, $requestData);
    }

    public function getByPortConfigurationId(string $haipName, int $portConfigurationId): PortConfiguration
    {
        $response                = $this->httpClient->get($this->getResourceUrl($haipName, $portConfigurationId));
        $portConfigurationStruct = $response['portConfiguration'] ?? [];

        return new PortConfiguration($portConfigurationStruct);
    }
}
