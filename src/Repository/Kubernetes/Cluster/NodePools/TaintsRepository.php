<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster\NodePools;

use Transip\Api\Library\Entity\Kubernetes\Taint;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\Cluster\NodePoolRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class TaintsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'taints';
    public const RESOURCE_PARAMETER_SINGULAR = 'taint';
    public const RESOURCE_PARAMETER_PLURAL = 'taints';

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
     * @return Taint[]
     */
    public function getAll($clusterName, $nodePoolUuid): array
    {
        $taints      = [];
        $response    = $this->httpClient->get($this->getResourceUrl($clusterName, $nodePoolUuid));
        $taintsArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($taintsArray as $taintArray) {
            $taints[] = new Taint($taintArray);
        }

        return $taints;
    }

    /**
     * @param string $clusterName
     * @param string $nodePoolUuid
     * @param Taint[] $taints
     * @return void
     */
    public function update(string $clusterName, string $nodePoolUuid, array $taints): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($clusterName, $nodePoolUuid),
            [self::RESOURCE_PARAMETER_PLURAL => $taints]
        );
    }
}
