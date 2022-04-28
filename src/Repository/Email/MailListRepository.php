<?php

namespace Transip\Api\Library\Repository\Email;

use Transip\Api\Library\Entity\Email\MailList;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\EmailRepository;

class MailListRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'mail-lists';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [EmailRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return MailList[]
     */
    public function getByDomainName(string $domainName): array
    {
        $mailLists      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($domainName));
        $mailListsArray = $this->getParameterFromResponse($response, 'lists');

        foreach ($mailListsArray as $mailListArray) {
            $mailLists[] = new MailList($mailListArray);
        }

        return $mailLists;
    }


    /**
     * @param string $domainName
     * @param int $mailListId
     * @return MailList
     */
    public function getByDomainNameAndId(string $domainName, int $mailListId): MailList
    {
        $response         = $this->httpClient->get($this->getResourceUrl($domainName, $mailListId));
        $mailListArray = $this->getParameterFromResponse($response, 'list');

        return new MailList($mailListArray);
    }

    /**
     * @param string $domainName
     * @param string $name
     * @param string $emailAddress
     * @param string[] $entries
     * @return void
     */
    public function create(
        string $domainName,
        string $name,
        string $emailAddress,
        array $entries
    ): void {
        $parameters = [
            'name'         => $name,
            'emailAddress' => $emailAddress,
            'entries'      => $entries
        ];

        $this->httpClient->post($this->getResourceUrl($domainName), $parameters);
    }

    /**
     * @param int $mailListId
     * @param string $domainName
     * @param string[] $entries
     * @return void
     */
    public function update(
        int $mailListId,
        string $domainName,
        array $entries
    ): void {
        $parameters = [
            'entries'      => $entries
        ];

        $this->httpClient->put($this->getResourceUrl($domainName, $mailListId), $parameters);
    }

    /**
     * @param int $mailListId
     * @param string $domainName
     * @return void
     */
    public function delete(
        int $mailListId,
        string $domainName
    ): void {
        $this->httpClient->delete($this->getResourceUrl($domainName, $mailListId), []);
    }
}
