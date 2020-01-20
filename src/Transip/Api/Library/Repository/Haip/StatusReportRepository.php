<?php

namespace Transip\Api\Library\Repository\Haip;

use Transip\Api\Library\Entity\Haip\StatusReport;
use Transip\Api\Library\Entity\Vps\IpAddress;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\HaipRepository;

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
        $statusReportArray = $this->getParameterFromResponse($response, 'statusReports');

        foreach ($statusReportArray as $statusReport) {
            $statusReports[] = new StatusReport($statusReport);
        }

        return $statusReports;
    }
}
