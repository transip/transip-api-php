<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster\NodePools;

use Transip\Api\Library\Entity\Kubernetes\Label;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\Cluster\NodePoolRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class LabelsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'labels';
    public const RESOURCE_PARAMETER_SINGULAR = 'label';
    public const RESOURCE_PARAMETER_PLURAL = 'labels';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, NodePoolRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $clusterName
     * @param string $nodePoolUuid
     * @return Label[]
     */
    public function getAll($clusterName, $nodePoolUuid): array
    {
        $labels      = [];
        $response    = $this->httpClient->get($this->getResourceUrl($clusterName, $nodePoolUuid));
        $labelsArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($labelsArray as $labelArray) {
            $labels[] = new Label($labelArray);
        }

        return $labels;
    }

    /**
     * @param string $clusterName
     * @param string $nodePoolUuid
     * @param Label[] $labels
     */
    public function update(string $clusterName, string $nodePoolUuid, array $labels): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($clusterName, $nodePoolUuid),
            [self::RESOURCE_PARAMETER_PLURAL => $labels]
        );
    }
}
