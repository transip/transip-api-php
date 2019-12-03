<?php

namespace Transip\Api\Client\Repository\Haip;

use Transip\Api\Client\Entity\Haip\StatusReport;
use Transip\Api\Client\Entity\Vps\IpAddress;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\HaipRepository;

class StatusReportRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'status-reports';

    protected function getRepositoryResourceNames(): array
    {
        return [HaipRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $haipName
     * @return StatusReport[]
     */
    public function getByHaipName(string $haipName): array
    {
        $statusReports     = [];
        $response          = $this->httpClient->get($this->getResourceUrl($haipName));
        $statusReportArray = $response['statusReports'] ?? [];

        foreach ($statusReportArray as $statusReport) {
            $statusReports[] = new StatusReport($statusReport);
        }

        return $statusReports;
    }
}
