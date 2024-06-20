<?php

namespace Transip\Api\Library\Repository\Acronis\Tenant;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Repository\Acronis\TenantRepository;
use Transip\Api\Library\Repository\ApiRepository;

class UpgradesRepository extends ApiRepository
{
    public const RESOURCE_NAME  = 'upgrades';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [TenantRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function upgrade(string $tenantUuid, string $productName): ResponseInterface
    {
        return $this->httpClient->put($this->getResourceUrl($tenantUuid), ['productName' => $productName]);
    }
}
