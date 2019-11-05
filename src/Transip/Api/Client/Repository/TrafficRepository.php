<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\TrafficInformation;

class TrafficRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['traffic'];
    }

    public function getTrafficPool(): TrafficInformation
    {
        return $this->getByVpsName('');
    }

    public function getByVpsName(string $vpsName): TrafficInformation
    {
        $response           = $this->httpClient->get($this->getResourceUrl($vpsName));
        $trafficInformation = $response['trafficInformation'] ?? [];
        return new TrafficInformation($trafficInformation);
    }
}
