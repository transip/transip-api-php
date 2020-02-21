<?php

namespace Transip\Api\Library\Repository\BigStorage;

use Transip\Api\Library\Entity\Vps\UsageDataDisk;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\BigStorageRepository;

class UsageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'usage';

    protected function getRepositoryResourceNames(): array
    {
        return [BigStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $bigStorageName
     * @param int    $dateTimeStart
     * @param int    $dateTimeEnd
     * @return UsageDataDisk[]
     */
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
        $usageStatistics = $this->getParameterFromResponse($response, 'usage');

        foreach ($usageStatistics as $usage) {
            $usages[] = new UsageDataDisk($usage);
        }

        return $usages;
    }
}
