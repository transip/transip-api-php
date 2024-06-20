<?php

namespace Transip\Api\Library\Repository\Acronis;

use Psr\Http\Message\ResponseInterface;
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
     * @param string $productName
     * @param array<string> $addons
     * @return ResponseInterface
     */
    public function order(string $productName, array $addons = []): ResponseInterface
    {
        return $this->httpClient->post($this->getResourceUrl(), ['productName' => $productName, 'addons' => $addons]);
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

    public function updateTenant(Tenant $tenant): void
    {
        $parameters = [
            'tenant' => $tenant,
        ];

        $this->httpClient->put(
            $this->getResourceUrl($tenant->getUuid()),
            $parameters
        );
    }

    public function cancel(string $tenantUuid, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($tenantUuid), ['endTime' => $endTime]);
    }
}
