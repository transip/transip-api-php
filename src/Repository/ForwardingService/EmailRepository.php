<?php

namespace Transip\Api\Library\Repository\ForwardingService;

use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\ForwardingServiceRepository;

class EmailRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'email';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ForwardingServiceRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return string|null the email address that email is forwarded to, null when email is not forwarded
     */
    public function getForwardTo(string $domainName): ?string
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));

        // forwardTo is null when email is not forwarded, so getParameterFromResponse() cannot be used
        return $response['forwardTo'] ?? null;
    }

    /**
     * Forward email for the domain name to the given email address
     *
     * @param string $domainName
     * @param string $forwardTo
     */
    public function setForwardTo(string $domainName, string $forwardTo): void
    {
        $this->httpClient->put($this->getResourceUrl($domainName), ['forwardTo' => $forwardTo]);
    }

    /**
     * Stop forwarding email for the domain name
     *
     * @param string $domainName
     */
    public function removeForwardTo(string $domainName): void
    {
        $this->httpClient->delete($this->getResourceUrl($domainName));
    }
}
