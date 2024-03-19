<?php

namespace Transip\Api\Library\Repository\Acronis\Tenant;

use Transip\Api\Library\Entity\Acronis\Usage;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Acronis\TenantRepository;

class UsageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'usage';
    
    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [TenantRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByTenantUuid(string $tenantUuid): Usage
    {
        $response      = $this->httpClient->get($this->getResourceUrl($tenantUuid));
        $acronisUsage  = $this->getParameterFromResponse($response, self::RESOURCE_NAME);

        return new Usage($acronisUsage);
    }
}
