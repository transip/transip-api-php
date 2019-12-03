<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Colocation;

class ColocationRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'colocations';

    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Colocation[]
     */
    public function getAll(): array
    {
        $colocations      = [];
        $response         = $this->httpClient->get($this->getResourceUrl());
        $colocationsArray = $response['colocations'] ?? [];

        foreach ($colocationsArray as $colocationArray) {
            $colocations[] = new Colocation($colocationArray);
        }

        return $colocations;
    }

    public function getByName(string $name): Colocation
    {
        $response   = $this->httpClient->get($this->getResourceUrl($name));
        $colocation = $response['colocation'] ?? null;
        return new Colocation($colocation);
    }
}
