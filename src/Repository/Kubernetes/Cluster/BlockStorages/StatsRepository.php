<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster\BlockStorages;

use Transip\Api\Library\Entity\Vps\UsageDataDisk;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\Cluster\BlockStorageRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class StatsRepository extends ApiRepository
{
    public const TYPE_CPU = 'cpu';
    public const TYPE_DISK = 'disk';
    public const TYPE_NETWORK = 'network';
    public const RESOURCE_NAME = 'stats';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, BlockStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $clusterName
     * @param string $blockStorageName
     * @param int $dateTimeStart
     * @param int $dateTimeEnd
     * @return UsageDataDisk[]
     */
    public function getByName(
        string $clusterName,
        string $blockStorageName,
        int $dateTimeStart = 0,
        int $dateTimeEnd = 0
    ): array {
        $usages     = [];
        $parameters = [];

        if ($dateTimeStart > 0) {
            $parameters['dateTimeStart'] = $dateTimeStart;
        }
        if ($dateTimeEnd > 0) {
            $parameters['dateTimeEnd'] = $dateTimeEnd;
        }

        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $blockStorageName), $parameters);
        $usageStatistics = $this->getParameterFromResponse($response, 'stats');

        foreach ($usageStatistics as $usage) {
            $usages[] = new UsageDataDisk($usage);
        }

        return $usages;
    }
}
