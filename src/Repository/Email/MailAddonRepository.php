<?php

declare(strict_types=1);

namespace Transip\Api\Library\Repository\Email;

use Transip\Api\Library\Entity\Email\MailAddon;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\EmailRepository;

class MailAddonRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'mail-addons';

    protected function getRepositoryResourceNames(): array
    {
        return [EmailRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return MailAddon[]
     */
    public function getByDomainName(string $domainName): array
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName));
        $responseArray = $this->getParameterFromResponse($response, 'addons');

        return array_map(function ($addon) {
            return new MailAddon($addon);
        }, $responseArray);
    }

    public function linkAddonToMailBox(string $domainName, string $emailAddress, int $addonId): void
    {
        $this->httpClient->patch($this->getResourceUrl($domainName), [
            'action' => 'linkmailbox',
            'addonId' => $addonId,
            'mailbox' => $emailAddress,
        ]);
    }

    public function unlinkAddonFromMailBox(string $domainName, string $emailAddress, int $addonId): void
    {
        $this->httpClient->patch($this->getResourceUrl($domainName), [
            'action' => 'unlinkmailbox',
            'addonId' => $addonId,
            'mailbox' => $emailAddress,
        ]);
    }
}
