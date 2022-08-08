<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class AuthCodeRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'authCode';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByDomainName(string $domainName): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $authCode = $this->getParameterFromResponse($response, 'authCode');

        return $authCode;
    }

    public function requestForDomainName(string $domainName): void
    {
        $this->httpClient->post($this->getResourceUrl($domainName));
    }
}
