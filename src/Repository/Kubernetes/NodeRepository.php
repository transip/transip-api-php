<?php

namespace Transip\Api\Library\Repository\Kubernetes;

use Transip\Api\Library\Entity\Kubernetes\Node;
use Transip\Api\Library\Repository\ApiRepository;

class NodeRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kubernetes/nodes';
    public const RESOURCE_PARAMETER_SINGULAR = 'node';
    public const RESOURCE_PARAMETER_PLURAL = 'nodes';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Node[]
     */
    public function getAll(): array
    {
        return $this->getNodes();
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return Node[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        return $this->getNodes([], $page, $itemsPerPage);
    }

    /**
     * @param string $clusterName
     * @param int    $page
     * @param int    $itemsPerPage
     * @return Node[]
     */
    public function getByClusterName(string $clusterName, int $page = 0, int $itemsPerPage = 0): array
    {
        return $this->getNodes(['clusterName' => $clusterName], $page, $itemsPerPage);
    }

    /**
     * @param string $nodePoolUuid
     * @param int    $page
     * @param int    $itemsPerPage
     * @return Node[]
     */
    public function getByNodePoolUuid(string $nodePoolUuid, int $page = 0, int $itemsPerPage = 0): array
    {
        return $this->getNodes(['nodePoolUuid' => $nodePoolUuid], $page, $itemsPerPage);
    }

    /**
     * @param mixed[] $query
     * @param int     $itemsPerPage
     * @param int     $page
     * @return Node[]
     */
    private function getNodes(array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $nodes = [];
        $query['page'] = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl(), $query);

        $nodesArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($nodesArray as $nodeArray) {
            $nodes[] = new Node($nodeArray);
        }

        return $nodes;
    }

    public function getByUuid(string $nodeUuid): Node
    {
        $response = $this->httpClient->get($this->getResourceUrl($nodeUuid));
        $node = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new Node($node);
    }
}
