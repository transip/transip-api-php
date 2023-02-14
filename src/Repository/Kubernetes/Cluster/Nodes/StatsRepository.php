<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster\Nodes;

use Transip\Api\Library\Entity\Vps\UsageData;
use Transip\Api\Library\Entity\Vps\UsageDataCpu;
use Transip\Api\Library\Entity\Vps\UsageDataDisk;
use Transip\Api\Library\Entity\Vps\UsageDataNetwork;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\Cluster\NodeRepository;
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
        return [ClusterRepository::RESOURCE_NAME, NodeRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string[] $types
     * @return array<string, array<int, UsageData>>
     */
    public function getByNodeUuid(
        string $clusterName,
        string $nodeUuid,
        array $types = [],
        int $dateTimeStart = 0,
        int $dateTimeEnd = 0
    ): array {
        $parameters = [];
        if (count($types) > 0) {
            $parameters['types'] = implode(',', $types);
        }
        if ($dateTimeStart > 0) {
            $parameters['dateTimeStart'] = $dateTimeStart;
        }
        if ($dateTimeEnd > 0) {
            $parameters['dateTimeEnd'] = $dateTimeEnd;
        }

        $usages          = [];
        $response        = $this->httpClient->get($this->getResourceUrl($clusterName, $nodeUuid), $parameters);
        $usageTypesArray = $this->getParameterFromResponse($response, 'stats');

        foreach ($usageTypesArray as $usageType => $usageArray) {
            $usageType = (string)$usageType;
            switch ($usageType) {
                case self::TYPE_CPU:
                    foreach ($usageArray as $usage) {
                        $usages[$usageType][] = new UsageDataCpu($usage);
                    }
                    break;
                case self::TYPE_DISK:
                    foreach ($usageArray as $usage) {
                        $usages[$usageType][] = new UsageDataDisk($usage);
                    }
                    break;
                case self::TYPE_NETWORK:
                    foreach ($usageArray as $usage) {
                        $usages[$usageType][] = new UsageDataNetwork($usage);
                    }
                    break;
            }
        }

        return $usages;
    }
}
