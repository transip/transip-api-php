<?php

namespace Transip\Api\Library\Repository\OpenStack\Project;

use Transip\Api\Library\Entity\ObjectStoreQuota;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\OpenStack\ProjectRepository;

class QuotaRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'quota';

    public const RESOURCE_PARAMETER_PLURAL   = 'quotas';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ProjectRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $projectId
     * @return ObjectStoreQuota
     */
    public function getByProjectId(string $projectId): ObjectStoreQuota
    {
        $response   = $this->httpClient->get($this->getResourceUrl($projectId));
        return $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);
    }

    public function set(string $projectId, int $bytesQuota): void
    {
        $url        = $this->getResourceUrl($projectId);
        $parameters = ['bytesQuota' => $bytesQuota];

        $this->httpClient->post($url, $parameters);
    }

}
