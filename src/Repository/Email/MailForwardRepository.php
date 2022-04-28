<?php

namespace Transip\Api\Library\Repository\Email;

use Transip\Api\Library\Entity\Email\MailForward;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\EmailRepository;

class MailForwardRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'mail-forwards';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [EmailRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return MailForward[]
     */
    public function getByDomainName(string $domainName): array
    {
        $mailForwards      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($domainName));
        $mailForwardsArray = $this->getParameterFromResponse($response, 'forwards');

        foreach ($mailForwardsArray as $mailForwardArray) {
            $mailForwards[] = new MailForward($mailForwardArray);
        }

        return $mailForwards;
    }

    /**
     * @param string $domainName
     * @param int $mailForwardId
     * @return MailForward
     */
    public function getByDomainNameAndId(string $domainName, int $mailForwardId): MailForward
    {
        $response         = $this->httpClient->get($this->getResourceUrl($domainName, $mailForwardId));
        $mailForwardArray = $this->getParameterFromResponse($response, 'forward');

        return new MailForward($mailForwardArray);
    }

    /**
     * @param string $domainName
     * @param string $localPart
     * @param string $forwardTo
     * @return void
     */
    public function create(
        string $domainName,
        string $localPart,
        string $forwardTo
    ): void {
        $parameters = [
            'localPart'   => $localPart,
            'forwardTo'   => $forwardTo,
        ];

        $this->httpClient->post($this->getResourceUrl($domainName), $parameters);
    }

    /**
     * @param int $mailForwardId
     * @param string $domainName
     * @param string $localPart
     * @param string $forwardTo
     * @return void
     */
    public function update(
        int $mailForwardId,
        string $domainName,
        string $localPart,
        string $forwardTo
    ): void {
        $parameters = [
            'localPart'   => $localPart,
            'forwardTo'   => $forwardTo,
        ];

        $this->httpClient->put($this->getResourceUrl($domainName, $mailForwardId), $parameters);
    }

    /**
     * @param int $mailForwardId
     * @param string $domainName
     * @return void
     */
    public function delete(
        int $mailForwardId,
        string $domainName
    ): void {
        $this->httpClient->delete($this->getResourceUrl($domainName, $mailForwardId), []);
    }
}
