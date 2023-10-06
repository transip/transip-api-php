<?php

namespace Transip\Api\Library\Repository\BlockStorage;

use Transip\Api\Library\Entity\Vps\UsageDataDisk;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\BlockStorageRepository;

class UsageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'usage';

    /**
     * @return array|string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [BlockStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return UsageDataDisk[]
     */
    public function getUsageStatistics(
        string $blockStorageName,
        int    $dateTimeStart = 0,
        int    $dateTimeEnd = 0
    ): array {
        $usages     = [];
        $parameters = [];

        if ($dateTimeStart > 0) {
            $parameters['dateTimeStart'] = $dateTimeStart;
        }
        if ($dateTimeEnd > 0) {
            $parameters['dateTimeEnd'] = $dateTimeEnd;
        }

        $response = $this->httpClient->get($this->getResourceUrl($blockStorageName), $parameters);
        $usageStatistics = $this->getParameterFromResponse($response, 'usage');

        foreach ($usageStatistics as $usage) {
            $usages[] = new UsageDataDisk($usage);
        }

        return $usages;
    }
}
