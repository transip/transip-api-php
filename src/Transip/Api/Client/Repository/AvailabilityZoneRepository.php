<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\AvailabilityZone;

class AvailabilityZoneRepository extends ApiRepository
{
    protected $repositoryEndpoint = 'availability-zone';

    /**
     * @return AvailabilityZone[]
     */
    public function getAll(): array
    {
        $availabilityZones      = [];
        $response               = $this->httpClient->get($this->endpoint);
        $availabilityZonesArray = $response['availabilityZones'] ?? [];

        foreach ($availabilityZonesArray as $availabilityZoneArray) {
            $availabilityZones[] = new AvailabilityZone($availabilityZoneArray);
        }

        return $availabilityZones;
    }

    public function getByName(string $name): ?AvailabilityZone
    {
        $url              = "{$this->endpoint}/{$name}";
        $response         = $this->httpClient->get($url);
        $availabilityZone = $response['availabilityZone'] ?? null;

        if ($availabilityZone !== null) {
            $availabilityZone = new AvailabilityZone($availabilityZone);
        }

        return $availabilityZone;
    }
}
