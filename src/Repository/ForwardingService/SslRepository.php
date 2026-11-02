<?php

namespace Transip\Api\Library\Repository\ForwardingService;

use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\ForwardingServiceRepository;

class SslRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ssl';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ForwardingServiceRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return string one of the ForwardingService::SSL_STATUS_* constants
     */
    public function getStatus(string $domainName): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));

        return $this->getParameterFromResponse($response, 'sslStatus');
    }

    public function enable(string $domainName): void
    {
        $this->httpClient->patch($this->getResourceUrl($domainName), ['action' => 'enable']);
    }

    public function disable(string $domainName): void
    {
        $this->httpClient->patch($this->getResourceUrl($domainName), ['action' => 'disable']);
    }
}
