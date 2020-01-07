<?php

namespace Transip\Api\Client\Repository\BigStorage;

use Transip\Api\Client\Entity\Vps\UsageDataDisk;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\BigStorageRepository;

class UsageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'usage';

    protected function getRepositoryResourceNames(): array
    {
        return [BigStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getUsageStatistics(
        string $bigStorageName,
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

        $response = $this->httpClient->get($this->getResourceUrl($bigStorageName), $parameters);
        $usageStatistics = $response['usage'] ?? null;

        foreach($usageStatistics as $usage) {
            $usages[] = new UsageDataDisk($usage);
        }

        return $usages;
    }
}
