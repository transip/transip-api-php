<?php

namespace Transip\Api\Library\Repository\Kubernetes;

use Transip\Api\Library\Entity\Kubernetes\Cluster;
use Transip\Api\Library\Repository\ApiRepository;

class ClusterRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kubernetes/clusters';

    public const RESOURCE_PARAMETER_SINGULAR = 'cluster';
    public const RESOURCE_PARAMETER_PLURAL   = 'clusters';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Cluster[]
     */
    public function getAll(): array
    {
        return $this->getClusters();
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return Cluster[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        return $this->getClusters([], $page, $itemsPerPage);
    }

    /**
     * @param mixed[] $query
     * @param int   $page
     * @param int   $itemsPerPage
     * @return Cluster[]
     */
    private function getClusters(array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $clusters      = [];
        $query['page'] = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl(), $query);
        $clustersArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($clustersArray as $clusterArray) {
            $clusters[] = new Cluster($clusterArray);
        }

        return $clusters;
    }

    public function create(string $kubernetesVersion = null, ?string $description = '', ?string $nodeSpec = null, ?int $desiredNodeCount = null, string $availabilityZone = null): void
    {
        $parameters = [
            'kubernetesVersion' => $kubernetesVersion,
            'description'       => $description ?? '',
            'nodeSpec'          => $nodeSpec,
            'desiredNodeCount'  => $desiredNodeCount,
            'availabilityZone'  => $availabilityZone,
        ];

        $this->httpClient->post(
            $this->getResourceUrl(),
            $parameters
        );
    }

    public function getByName(string $clusterName): Cluster
    {
        $response  = $this->httpClient->get($this->getResourceUrl($clusterName));
        $clusterArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new Cluster($clusterArray);
    }

    public function updateCluster(Cluster $cluster): void
    {
        $parameters = [
            'cluster' => $cluster,
        ];

        $this->httpClient->put(
            $this->getResourceUrl($cluster->getName()),
            $parameters
        );
    }

    public function handover(string $clusterName, string $targetCustomerName): void
    {
        $parameters = [
            'action'             => 'handover',
            'targetCustomerName' => $targetCustomerName,
        ];

        $this->httpClient->patch(
            $this->getResourceUrl($clusterName),
            $parameters
        );
    }

    public function reset(string $clusterName, string $confirmation): void
    {
        $parameters = [
            'action'       => 'reset',
            'confirmation' => $confirmation
        ];

        $this->httpClient->patch(
            $this->getResourceUrl($clusterName),
            $parameters
        );
    }

    public function upgrade(string $clusterName, string $version): void
    {
        $parameters = [
            'action'  => 'upgrade',
            'version' => $version
        ];

        $this->httpClient->patch(
            $this->getResourceUrl($clusterName),
            $parameters
        );
    }

    public function remove(string $clusterName): void
    {
        $this->httpClient->delete(
            $this->getResourceUrl($clusterName)
        );
    }
}
