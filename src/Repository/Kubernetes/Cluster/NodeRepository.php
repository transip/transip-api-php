<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\Node;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class NodeRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'nodes';
    public const RESOURCE_PARAMETER_SINGULAR = 'node';
    public const RESOURCE_PARAMETER_PLURAL = 'nodes';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return Node[]
     */
    public function getAll(string $clusterName): array
    {
        return $this->getNodes($clusterName);
    }

    /**
     * @return Node[]
     */
    public function getSelection(string $clusterName, int $page, int $itemsPerPage): array
    {
        return $this->getNodes($clusterName, [], $page, $itemsPerPage);
    }

    /**
     * @return Node[]
     */
    public function getByNodePoolUuid(string $clusterName, string $nodePoolUuid, int $page = 0, int $itemsPerPage = 0): array
    {
        return $this->getNodes($clusterName, ['nodePoolUuid' => $nodePoolUuid], $page, $itemsPerPage);
    }

    /**
     * @param array<string, mixed> $query
     * @return Node[]
     */
    private function getNodes(string $clusterName, array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $nodes = [];
        $query['page'] = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl($clusterName), $query);

        $nodesArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($nodesArray as $nodeArray) {
            $nodes[] = new Node($nodeArray);
        }

        return $nodes;
    }

    public function getByUuid(string $clusterName, string $nodeUuid): Node
    {
        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $nodeUuid));
        $node = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new Node($node);
    }

    /**
     * @param string $clusterName
     * @param string[] $uuids
     * @return Node[]
     */
    public function getByUuids(string $clusterName, array $uuids): array
    {
        return array_map(fn (string $uuid) => $this->getByUuid($clusterName, $uuid), $uuids);
    }

    public function reboot(string $clusterName, string $nodeUuid): void
    {
        $this->httpClient->patch($this->getResourceUrl($clusterName, $nodeUuid), ['action' => 'reboot']);
    }
}
