<?php

namespace Transip\Api\Client\Repository\Colocation;

use Transip\Api\Client\Entity\Colocation\RemoteHands;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\ColocationRepository;

class RemoteHandsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'remote-hands';

    protected function getRepositoryResourceNames(): array
    {
        return [ColocationRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function create(RemoteHands $remoteHands): void
    {
        $url        = $this->getResourceUrl($remoteHands->getColoName());
        $parameters = ['remoteHands' => $remoteHands];
        $this->httpClient->post($url, $parameters);
    }
}
