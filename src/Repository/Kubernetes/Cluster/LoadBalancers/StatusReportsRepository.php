<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster\LoadBalancers;

use Transip\Api\Library\Entity\Kubernetes\LoadBalancer\StatusReport;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\Cluster\LoadBalancerRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class StatusReportsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'status-reports';
    public const RESOURCE_PARAMETER_SINGULAR = 'statusReport';
    public const RESOURCE_PARAMETER_PLURAL = 'statusReports';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, LoadBalancerRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return StatusReport[]
     */
    public function getAll(string $clusterName, string $loadBalancerName): array
    {
        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $loadBalancerName));

        $reportsStructs = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        $statusReports = [];
        foreach ($reportsStructs as $reportsStruct) {
            $statusReports[] = new StatusReport($reportsStruct);
        }
        return $statusReports;
    }

    /**
     * @return array<int, StatusReport[]>
     */
    public function getAllGroupedByPort(string $clusterName, string $loadBalancerName): array
    {
        $statusReportsPerPort = [];

        foreach ($this->getAll($clusterName, $loadBalancerName) as $statusReport) {
            $statusReportsPerPort[$statusReport->getPort()][] = $statusReport;
        }

        return $statusReportsPerPort;
    }

    /**
     * @return StatusReport[]
     */
    public function getByNodeUuid(string $clusterName, string $loadBalancerName, string $nodeUuid): array
    {
        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $loadBalancerName, $nodeUuid));

        $reportsStructs = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        $statusReports = [];
        foreach ($reportsStructs as $reportsStruct) {
            $statusReports[] = new StatusReport($reportsStruct);
        }
        return $statusReports;
    }

    /**
     * @return array<int, StatusReport[]>
     */
    public function getByNodeUuidGroupedByPort(string $clusterName, string $loadBalancerName, string $nodeUuid): array
    {
        $statusReportsPerPort = [];

        foreach ($this->getByNodeUuid($clusterName, $loadBalancerName, $nodeUuid) as $statusReport) {
            $statusReportsPerPort[$statusReport->getPort()][] = $statusReport;
        }

        return $statusReportsPerPort;
    }
}
