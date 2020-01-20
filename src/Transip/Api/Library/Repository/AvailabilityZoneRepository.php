<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\AvailabilityZone;

class AvailabilityZoneRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'availability-zones';

    /**
     * @return AvailabilityZone[]
     */
    public function getAll(): array
    {
        $availabilityZones      = [];
        $response               = $this->httpClient->get($this->getResourceUrl());
        $availabilityZonesArray = $this->getParameterFromResponse($response, 'availabilityZones');

        foreach ($availabilityZonesArray as $availabilityZoneArray) {
            $availabilityZones[] = new AvailabilityZone($availabilityZoneArray);
        }

        return $availabilityZones;
    }
}
