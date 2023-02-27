<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\NodePool;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class NodePoolRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'node-pools';
    public const RESOURCE_PARAMETER_SINGULAR = 'nodePool';
    public const RESOURCE_PARAMETER_PLURAL = 'nodePools';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return NodePool[]
     */
    public function getAll(string $clusterName): array
    {
        return $this->getNodePools($clusterName);
    }

    /**
     * @return NodePool[]
     */
    public function getSelection(string $clusterName, int $page, int $itemsPerPage): array
    {
        return $this->getNodePools($clusterName, [], $page, $itemsPerPage);
    }

    /**
     * @param array<string, mixed> $query
     * @return NodePool[]
     */
    private function getNodePools(string $clusterName, array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $nodePools         = [];
        $query['page']     = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl($clusterName), $query);

        $nodePoolsArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($nodePoolsArray as $nodePoolArray) {
            $nodePools[] = new NodePool($nodePoolArray);
        }

        return $nodePools;
    }

    public function getByUuid(string $clusterName, string $nodePoolUuid): NodePool
    {
        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $nodePoolUuid));
        $nodePool = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new NodePool($nodePool);
    }

    public function add(
        string $clusterName,
        int $desiredNodeCount,
        string $nodeSpec,
        string $availabilityZone,
        ?string $description = null
    ): void {
        $parameters['clusterName']      = $clusterName;
        $parameters['desiredNodeCount'] = $desiredNodeCount;
        $parameters['nodeSpec']         = $nodeSpec;
        $parameters['availabilityZone'] = $availabilityZone;

        if ($description !== null) {
            $parameters['description'] = $description;
        }

        $this->httpClient->post($this->getResourceUrl($clusterName), $parameters);
    }

    public function update(string $clusterName, NodePool $nodePool): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($clusterName, $nodePool->getUuid()),
            [self::RESOURCE_PARAMETER_SINGULAR => $nodePool]
        );
    }

    public function remove(string $clusterName, string $nodePoolUuid): void
    {
        $this->httpClient->delete($this->getResourceUrl($clusterName, $nodePoolUuid));
    }
}
