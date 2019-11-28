<?php

namespace Transip\Api\Client\Repository\Haip;

use Transip\Api\Client\Entity\Haip\StatusReport;
use Transip\Api\Client\Entity\Vps\IpAddress;
use Transip\Api\Client\Repository\ApiRepository;

class StatusReportRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['haips', 'status-reports'];
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
