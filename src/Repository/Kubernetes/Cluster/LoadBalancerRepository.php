<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\LoadBalancer;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class LoadBalancerRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'load-balancers';
    public const RESOURCE_PARAMETER_SINGULAR = 'loadBalancer';
    public const RESOURCE_PARAMETER_PLURAL = 'loadBalancers';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return LoadBalancer[]
     */
    public function getAll(string $clusterName): array
    {
        return $this->getLoadBalancers($clusterName);
    }

    /**
     * @return LoadBalancer[]
     */
    public function getSelection(string $clusterName, int $page, int $itemsPerPage): array
    {
        return $this->getLoadBalancers($clusterName, [], $page, $itemsPerPage);
    }

    /**
     * @param array<string, mixed> $query
     * @return LoadBalancer[]
     */
    private function getLoadBalancers(string $clusterName, array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $loadBalancers     = [];
        $query['page']     = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl($clusterName), $query);

        $loadBalancersArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($loadBalancersArray as $loadBalancerArray) {
            $loadBalancers[] = new LoadBalancer($loadBalancerArray);
        }

        return $loadBalancers;
    }

    public function getByName(string $clusterName, string $loadBalancerName): LoadBalancer
    {
        $response          = $this->httpClient->get($this->getResourceUrl($clusterName, $loadBalancerName));
        $loadBalancerArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new LoadBalancer($loadBalancerArray);
    }

    public function getByUuid(string $clusterName, string $loadBalancerUuid): LoadBalancer
    {
        $response         = $this->httpClient->get($this->getResourceUrl($clusterName, $loadBalancerUuid));
        $loadBalancerArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new LoadBalancer($loadBalancerArray);
    }

    public function add(string $name): void
    {
        $parameters = [
            'name' => $name,
        ];

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function remove(string $clusterName, string $loadBalancerName): void
    {
        $this->httpClient->delete($this->getResourceUrl($clusterName, $loadBalancerName));
    }
}
