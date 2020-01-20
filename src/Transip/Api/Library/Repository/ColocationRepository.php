<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Colocation;

class ColocationRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'colocations';

    /**
     * @return Colocation[]
     */
    public function getAll(): array
    {
        $colocations      = [];
        $response         = $this->httpClient->get($this->getResourceUrl());
        $colocationsArray = $this->getParameterFromResponse($response, 'colocations');

        foreach ($colocationsArray as $colocationArray) {
            $colocations[] = new Colocation($colocationArray);
        }

        return $colocations;
    }

    public function getByName(string $name): Colocation
    {
        $response   = $this->httpClient->get($this->getResourceUrl($name));
        $colocation = $this->getParameterFromResponse($response, 'colocation');

        return new Colocation($colocation);
    }
}
