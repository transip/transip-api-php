<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Domain\Verification;

class DomainVerificationRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'domain-verifications';

    /**
     * The API paginates this resource by default, getAll() fetches the pages with this size.
     */
    private const ITEMS_PER_PAGE_FOR_GET_ALL = 100;

    /**
     * Returns all verifications in your account. The contact and domain of the verifications are not
     * included, use getById() to retrieve those.
     *
     * @param string|null $domainName Only return the verifications of this domain name
     * @param string[]    $statuses   Only return verifications with one of these Verification::STATUS_* statuses
     * @return Verification[]
     */
    public function getAll(?string $domainName = null, array $statuses = []): array
    {
        $verifications = [];
        $page          = 1;

        do {
            $selection     = $this->getSelection($page, self::ITEMS_PER_PAGE_FOR_GET_ALL, $domainName, $statuses);
            $verifications = array_merge($verifications, $selection);
            $page++;
        } while (count($selection) === self::ITEMS_PER_PAGE_FOR_GET_ALL);

        return $verifications;
    }

    /**
     * @param int         $page
     * @param int         $itemsPerPage
     * @param string|null $domainName Only return the verifications of this domain name
     * @param string[]    $statuses   Only return verifications with one of these Verification::STATUS_* statuses
     * @return Verification[]
     */
    public function getSelection(
        int $page,
        int $itemsPerPage,
        ?string $domainName = null,
        array $statuses = []
    ): array {
        $query = ['pageSize' => $itemsPerPage, 'page' => $page];

        if ($domainName !== null && $domainName !== '') {
            $query['domainName'] = $domainName;
        }

        if (count($statuses) > 0) {
            // The API expects the statuses as a comma separated list
            $query['statuses'] = implode(',', $statuses);
        }

        $response           = $this->httpClient->get($this->getResourceUrl(), $query);
        $verificationsArray = $this->getParameterFromResponse($response, 'verifications');

        $verifications = [];
        foreach ($verificationsArray as $verificationArray) {
            // A list item is a summary: contact and domain are only part of getById()
            unset($verificationArray['contact'], $verificationArray['domain']);
            $verifications[] = new Verification($verificationArray);
        }

        return $verifications;
    }

    /**
     * Returns a single verification, including its contact and domain.
     */
    public function getById(int $id): Verification
    {
        $response          = $this->httpClient->get($this->getResourceUrl($id));
        $verificationArray = $this->getParameterFromResponse($response, 'verification');

        return new Verification($verificationArray);
    }
}
