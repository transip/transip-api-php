<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\Cluster\Release as KubernetesRelease;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class ReleaseRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'releases';
    public const RESOURCE_PARAMETER_SINGULAR = 'release';
    public const RESOURCE_PARAMETER_PLURAL   = 'releases';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return KubernetesRelease[]
     */
    public function getAll(string $clusterName): array
    {
        return $this->getReleases($clusterName, []);
    }

    /**
     * @return KubernetesRelease[]
     */
    public function getCompatibleUpgrades(string $clusterName): array
    {
        return $this->getReleases($clusterName, ['isCompatibleUpgrade' => true]);
    }

    public function getByVersion(string $clusterName, string $version): KubernetesRelease
    {
        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $version));

        return new KubernetesRelease($this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR));
    }

    /**
     * @param string $clusterName
     * @param array<string, mixed> $query
     * @return KubernetesRelease[]
     */
    private function getReleases(string $clusterName, array $query = []): array
    {
        $releases = [];

        $response = $this->httpClient->get($this->getResourceUrl($clusterName), $query);
        $releasesArrays = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($releasesArrays as $releasesArray) {
            $releases[] = new KubernetesRelease($releasesArray);
        }

        return $releases;
    }
}
