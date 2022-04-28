<?php

namespace Transip\Api\Library\Repository\Colocation;

use Transip\Api\Library\Entity\Colocation\AccessRequest;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\ColocationRepository;

class AccessRequestRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'access-request';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ColocationRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function create(AccessRequest $accessRequest): void
    {
        $url        = $this->getResourceUrl($accessRequest->getColoName());
        $parameters = ['accessRequest' => $accessRequest];
        $this->httpClient->post($url, $parameters);
    }
}
