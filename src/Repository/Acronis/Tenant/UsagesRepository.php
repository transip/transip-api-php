<?php

namespace Transip\Api\Library\Repository\Acronis\Tenant;

use Transip\Api\Library\Entity\Acronis\Usage;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Acronis\TenantRepository;

class UsagesRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'usages';
    
    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [TenantRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return Usage[]
     */
    public function getByTenantUuid(string $tenantUuid): array
    {
        $response      = $this->httpClient->get($this->getResourceUrl($tenantUuid));
        $acronisUsages = $this->getParameterFromResponse($response, self::RESOURCE_NAME);

        $usages =[];
        foreach ($acronisUsages as $acronisUsage) {
            $usages[] = new Usage($acronisUsage);
        }

        return $usages;
    }
}
