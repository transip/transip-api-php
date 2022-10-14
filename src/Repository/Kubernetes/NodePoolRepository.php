<?php

namespace Transip\Api\Library\Repository\Kubernetes;

use Transip\Api\Library\Entity\Kubernetes\NodePool;
use Transip\Api\Library\Repository\ApiRepository;

class NodePoolRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kubernetes/node-pools';
    public const RESOURCE_PARAMETER_SINGULAR = 'nodePool';
    public const RESOURCE_PARAMETER_PLURAL = 'nodePools';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return NodePool[]
     */
    public function getAll(): array
    {
        return $this->getNodePools();
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return NodePool[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        return $this->getNodePools([], $page, $itemsPerPage);
    }

    /**
     * @param string $clusterName
     * @return NodePool[]
     */
    public function getByClusterName(string $clusterName, int $page = 0, int $itemsPerPage = 0): array
    {
        return $this->getNodePools(['clusterName' => $clusterName], $page, $itemsPerPage);
    }

    /**
     * @param mixed[] $query
     * @return NodePool[]
     */
    private function getNodePools(array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $nodePools         = [];
        $query['page']     = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl(), $query);

        $nodePoolsArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($nodePoolsArray as $nodePoolArray) {
            $nodePools[] = new NodePool($nodePoolArray);
        }

        return $nodePools;
    }

    public function getByUuid(string $nodePoolUuid): NodePool
    {
        $response = $this->httpClient->get($this->getResourceUrl($nodePoolUuid));
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

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(NodePool $nodePool): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($nodePool->getUuid()),
            [self::RESOURCE_PARAMETER_SINGULAR => $nodePool]
        );
    }

    public function remove(string $nodePoolUuid): void
    {
        $this->httpClient->delete($this->getResourceUrl($nodePoolUuid));
    }
}
