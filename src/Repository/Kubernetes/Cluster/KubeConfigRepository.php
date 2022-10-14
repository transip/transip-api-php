<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\Cluster\KubeConfig;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class KubeConfigRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kube-config';
    public const RESOURCE_PARAMETER_SINGULAR = 'kubeConfig';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByClusterName(string $clusterName): KubeConfig
    {
        $response      = $this->httpClient->get($this->getResourceUrl($clusterName));
        $kubeConfigArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new KubeConfig($kubeConfigArray);
    }
}
