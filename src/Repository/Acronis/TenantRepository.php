<?php

namespace Transip\Api\Library\Repository\Acronis;

use Transip\Api\Library\Entity\Acronis\Tenant;
use Transip\Api\Library\Repository\ApiRepository;

class TenantRepository extends ApiRepository
{
    public const RESOURCE_NAME               = 'acronis/tenants';
    public const RESOURCE_PARAMETER_SINGULAR = 'tenant';
    public const RESOURCE_PARAMETER_PLURAL   = 'tenants';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return Tenant
     */
    public function getByUuid(string $tenantUuid): Tenant
    {
        $response = $this->httpClient->get($this->getResourceUrl($tenantUuid));
        $tenant   = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new Tenant($tenant);
    }

    /**
     * @return Tenant[]
     */
    public function getAll(): array
    {
        $tenants       = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $tenantObjects = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($tenantObjects as $tenant) {
            $tenants[] = new Tenant($tenant);
        }

        return $tenants;
    }
}
