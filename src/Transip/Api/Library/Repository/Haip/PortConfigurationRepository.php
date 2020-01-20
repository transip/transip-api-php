<?php

namespace Transip\Api\Library\Repository\Haip;

use Transip\Api\Library\Entity\Haip\PortConfiguration;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\HaipRepository;

class PortConfigurationRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'port-configurations';

    protected function getRepositoryResourceNames(): array
    {
        return [HaipRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $haipName
     * @return PortConfiguration[]
     */
    public function getByHaipName(string $haipName): array
    {
        $portConfigurations     = [];
        $response               = $this->httpClient->get($this->getResourceUrl($haipName));
        $portConfigurationArray = $this->getParameterFromResponse($response, 'portConfigurations');

        foreach ($portConfigurationArray as $portConfigurationStruct) {
            $portConfigurations[] = new PortConfiguration($portConfigurationStruct);
        }

        return $portConfigurations;
    }

    public function getByPortConfigurationId(string $haipName, int $portConfigurationId): PortConfiguration
    {
        $response                = $this->httpClient->get($this->getResourceUrl($haipName, $portConfigurationId));
        $portConfigurationStruct = $this->getParameterFromResponse($response, 'portConfiguration');

        return new PortConfiguration($portConfigurationStruct);
    }

    public function update(string $haipName, PortConfiguration $portConfiguration): void
    {
        $url = $this->getResourceUrl($haipName, $portConfiguration->getId());

        $this->httpClient->put($url, ['portConfiguration' => $portConfiguration]);
    }

    public function delete(string $haipName, int $portConfigurationId): void
    {
        $url = $this->getResourceUrl($haipName, $portConfigurationId);
        $this->httpClient->delete($url);
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
}
