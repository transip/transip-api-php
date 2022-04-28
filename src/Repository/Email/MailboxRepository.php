<?php

namespace Transip\Api\Library\Repository\Email;

use Transip\Api\Library\Entity\Email\Mailbox;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\EmailRepository;

class MailboxRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'mailboxes';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [EmailRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return Mailbox[]
     */
    public function getByDomainName(string $domainName): array
    {
        $mailboxes      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($domainName));
        $mailboxesArray = $this->getParameterFromResponse($response, 'mailboxes');

        foreach ($mailboxesArray as $mailboxArray) {
            $mailboxes[] = new Mailbox($mailboxArray);
        }

        return $mailboxes;
    }


    /**
     * @param string $domainName
     * @param string $identifier
     * @return Mailbox
     */
    public function getByDomainNameAndIdentifier(string $domainName, string $identifier): Mailbox
    {
        $response         = $this->httpClient->get($this->getResourceUrl($domainName, $identifier));
        $mailboxArray = $this->getParameterFromResponse($response, 'mailbox');

        return new Mailbox($mailboxArray);
    }

    /**
     * @param string $domainName
     * @param string $localPart
     * @param int $maxDiskUsage
     * @param string $password
     * @param string $forwardTo
     * @return void
     */
    public function create(
        string $domainName,
        string $localPart,
        int $maxDiskUsage,
        string $password,
        string $forwardTo
    ): void {
        $parameters = [
            'localPart'   => $localPart,
            'maxDiskUsage'   => $maxDiskUsage,
            'password'       => $password,
            'forwardTo'      => $forwardTo,
        ];

        $this->httpClient->post($this->getResourceUrl($domainName), $parameters);
    }

    /**
     * @param string $identifier
     * @param string $domainName
     * @param int $maxDiskUsage
     * @param string $password
     * @param string $forwardTo
     * @return void
     */
    public function update(
        string $identifier,
        string $domainName,
        int $maxDiskUsage,
        string $password,
        string $forwardTo
    ): void {
        $parameters = [
            'maxDiskUsage'   => $maxDiskUsage,
            'password'       => $password,
            'forwardTo'      => $forwardTo,
        ];

        $this->httpClient->put($this->getResourceUrl($domainName, $identifier), $parameters);
    }

    /**
     * @param string $identifier
     * @param string $domainName
     * @return void
     */
    public function delete(
        string $identifier,
        string $domainName
    ): void {
        $this->httpClient->delete($this->getResourceUrl($domainName, $identifier), []);
    }
}
