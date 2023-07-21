<?php

namespace Transip\Api\Library\Repository\Kubernetes;

use Transip\Api\Library\Entity\Kubernetes\Release as KubernetesRelease;
use Transip\Api\Library\Repository\ApiRepository;

class ReleaseRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kubernetes/releases';

    public const RESOURCE_PARAMETER_SINGULAR = 'release';
    public const RESOURCE_PARAMETER_PLURAL   = 'releases';

    /**
     * @return KubernetesRelease[]
     */
    public function getAll(): array
    {
        $releases = [];

        $response = $this->httpClient->get($this->getResourceUrl(), []);
        $releasesArrays = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($releasesArrays as $releasesArray) {
            $releases[] = new KubernetesRelease($releasesArray);
        }

        return $releases;
    }

    public function getByVersion(string $version): KubernetesRelease
    {
        $response = $this->httpClient->get($this->getResourceUrl($version));

        return new KubernetesRelease($this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR));
    }
}
