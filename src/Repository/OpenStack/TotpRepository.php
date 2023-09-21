<?php

namespace Transip\Api\Library\Repository\OpenStack;

use Transip\Api\Library\Entity\OpenStackTotp;
use Transip\Api\Library\Repository\ApiRepository;

class TotpRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'totp';

    public const RESOURCE_PARAMETER_SINGULAR = 'totp';
    public const RESOURCE_PARAMETER_PLURAL   = 'totps';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [UserRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }


    public function create(string $userId): OpenStackTotp
    {

        $response  = $this->httpClient->postWithResponse($this->getResourceUrl($userId));
        $token = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);
        return new OpenStackTotp($token);
    }


    public function delete(string $userId): void
    {
        $this->httpClient->delete(
            $this->getResourceUrl($userId)
        );
    }
}
