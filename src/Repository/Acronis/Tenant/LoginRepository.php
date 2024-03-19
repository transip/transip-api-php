<?php

namespace Transip\Api\Library\Repository\Acronis\Tenant;

use Transip\Api\Library\Repository\Acronis\TenantRepository;
use Transip\Api\Library\Repository\ApiRepository;

class LoginRepository extends ApiRepository
{
    public const RESOURCE_NAME  = 'login';
    public const RESPONSE_FIELD = 'loginUrl';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [TenantRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByTenantUuid(string $tenantUuid): string
    {
        $response      = $this->httpClient->get($this->getResourceUrl($tenantUuid));
        $acronisLogin  = $this->getParameterFromResponse($response, self::RESPONSE_FIELD);

        return $acronisLogin;
    }
}
