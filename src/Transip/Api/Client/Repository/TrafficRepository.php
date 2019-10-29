<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\TrafficInformation;

class TrafficRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['traffic'];
    }

    public function getTrafficPool(): ?TrafficInformation
    {
        $response           = $this->httpClient->get($this->getResourceUrl());
        $trafficInformation = $response['trafficInformation'] ?? [];

        if ($trafficInformation !== null) {
            $trafficInformation = new TrafficInformation($trafficInformation);
        }

        return $trafficInformation;
    }

    public function getByVpsName(string $vpsName): ?TrafficInformation
    {
        $response           = $this->httpClient->get($this->getResourceUrl($vpsName));
        $trafficInformation = $response['trafficInformation'] ?? [];

        if ($trafficInformation !== null) {
            $trafficInformation = new TrafficInformation($trafficInformation);
        }

        return $trafficInformation;
    }
}
