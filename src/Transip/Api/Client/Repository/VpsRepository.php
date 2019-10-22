<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Vps;

class VpsRepository extends ApiRepository
{
    protected $repositoryEndpoint = 'vps';

    /**
     * @return Vps[]
     */
    public function getAll(): array
    {
        $availabilityZones = [];
        $response          = $this->httpClient->get($this->endpoint);
        $vpsesArray        = $response['vpses'] ?? [];

        foreach ($vpsesArray as $vpsArray) {
            $availabilityZones[] = new Vps($vpsArray);
        }

        return $availabilityZones;
    }

    public function getByName(string $name): ?Vps
    {
        $url              = "{$this->endpoint}/{$name}";
        $response         = $this->httpClient->get($url);
        $availabilityZone = $response['vps'] ?? null;

        if ($availabilityZone !== null) {
            $availabilityZone = new Vps($availabilityZone);
        }

        return $availabilityZone;
    }
}
