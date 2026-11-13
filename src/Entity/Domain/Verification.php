<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

/**
 * A domain verification, used to verify actions on a domain, for example a change of registrant.
 *
 * The contact and domain are only filled when they are part of the response,
 * which is the case for DomainVerificationRepository::getById().
 */
class Verification extends AbstractEntity
{
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_FAILED    = 'failed';
    public const STATUS_PENDING   = 'pending';
    public const STATUS_SUCCESS   = 'success';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $domainName;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var int unix timestamp
     */
    protected $createdAt;

    /**
     * @var int unix timestamp, 0 when it was never updated
     */
    protected $updatedAt;

    /**
     * @var int unix timestamp, 0 when no response was received yet
     */
    protected $responseReceivedAt;

    /**
     * @var VerificationContact|null
     */
    protected $contact;

    /**
     * @var VerificationDomain|null
     */
    protected $domain;

    /**
     * @param mixed[] $valueArray
     */
    public function __construct(array $valueArray = [])
    {
        $contact = $valueArray['contact'] ?? [];
        if (is_array($contact) && $contact !== []) {
            $this->contact = new VerificationContact($contact);
        }

        $domain = $valueArray['domain'] ?? [];
        if (is_array($domain) && $domain !== []) {
            $this->domain = new VerificationDomain($domain);
        }

        unset($valueArray['contact'], $valueArray['domain']);
        parent::__construct($valueArray);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }

    public function getResponseReceivedAt(): int
    {
        return $this->responseReceivedAt;
    }

    public function getContact(): ?VerificationContact
    {
        return $this->contact;
    }

    public function getDomain(): ?VerificationDomain
    {
        return $this->domain;
    }
}
