<?php

namespace Transip\Api\Library\Repository\Colocation;

use Transip\Api\Library\Entity\Colocation\RemoteHands;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\ColocationRepository;

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
