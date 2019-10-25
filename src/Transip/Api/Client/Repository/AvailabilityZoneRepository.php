<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\AvailabilityZone;

class AvailabilityZoneRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['availability-zone'];
    }

    /**
     * @return AvailabilityZone[]
     */
    public function getAll(): array
    {
        $availabilityZones      = [];
        $response               = $this->httpClient->get($this->getResourceUrl());
        $availabilityZonesArray = $response['availabilityZones'] ?? [];

        foreach ($availabilityZonesArray as $availabilityZoneArray) {
            $availabilityZones[] = new AvailabilityZone($availabilityZoneArray);
        }

        return $availabilityZones;
    }

    public function getByName(string $name): ?AvailabilityZone
    {
        $response         = $this->httpClient->get($this->getResourceUrl($name));
        $availabilityZone = $response['availabilityZone'] ?? null;

        if ($availabilityZone !== null) {
            $availabilityZone = new AvailabilityZone($availabilityZone);
        }

        return $availabilityZone;
    }
}
