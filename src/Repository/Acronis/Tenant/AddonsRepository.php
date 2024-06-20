<?php

namespace Transip\Api\Library\Repository\Acronis\Tenant;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Repository\Acronis\TenantRepository;
use Transip\Api\Library\Repository\ApiRepository;

class AddonsRepository extends ApiRepository
{
    public const RESOURCE_NAME  = 'addons';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [TenantRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function order(string $tenantUuid, array $addons): ResponseInterface
    {
        return $this->httpClient->post($this->getResourceUrl($tenantUuid), ['addons' => $addons]);
    }

    public function cancel(string $tenantUuid, string $addon): void
    {
        $this->httpClient->delete($this->getResourceUrl($tenantUuid), ['addon' => $addon]);
    }
}
