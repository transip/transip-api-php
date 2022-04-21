<?php

namespace Transip\Api\Library\Entity;

use Transip\Api\Library\Entity\Domain\Nameserver;
use Transip\Api\Library\Entity\Domain\WhoisContact;

class Domain extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $authCode
     */
    protected $authCode;

    /**
     * @var bool $isTransferLocked
     */
    protected $isTransferLocked;

    /**
     * @var string $registrationDate
     */
    protected $registrationDate;

    /**
     * @var string $renewalDate
     */
    protected $renewalDate;

    /**
     * @var bool $isWhitelabel
     */
    protected $isWhitelabel;

    /**
     * @var string $cancellationDate
     */
    protected $cancellationDate;

    /**
     * @var string $cancellationStatus
     */
    protected $cancellationStatus;

    /**
     * @var bool $isDnsOnly
     */
    protected $isDnsOnly;

    /**
     * @var bool $hasAutoDns
     */
    protected $hasAutoDns;

    /**
     * @var array $tags
     */
    protected $tags = [];

    /**
     * @var string $status
     */
    protected $status = '';

    /**
     * @var Nameserver[] $nameservers
     */
    protected $nameservers = [];

    /**
     * @var WhoisContact[] $contacts
     */
    protected $contacts = [];

    public function __construct(array $valueArray = [])
    {
        foreach ($valueArray as $field => $value) {
            if ($field === 'nameservers') {
                $this->initNameservers($value);
                continue;
            }

            if ($field === 'contacts') {
                $this->initContacts($value);
                continue;
            }

            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    private function initNameservers(array $nameservers = [])
    {
        $this->nameservers = array_map(static function ($nameserver) {
            return new Nameserver(($nameserver));
        }, $nameservers);
    }

    private function initContacts(array $contacts = [])
    {
        $this->contacts = array_map(static function ($contact) {
            return new WhoisContact($contact);
        }, $contacts);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAuthCode(): string
    {
        return $this->authCode;
    }

    public function isTransferLocked(): bool
    {
        return $this->isTransferLocked;
    }

    public function getRegistrationDate(): string
    {
        return $this->registrationDate;
    }

    public function getRenewalDate(): string
    {
        return $this->renewalDate;
    }

    public function isWhitelabel(): bool
    {
        return $this->isWhitelabel;
    }

    public function getCancellationDate(): string
    {
        return $this->cancellationDate;
    }

    public function getCancellationStatus(): string
    {
        return $this->cancellationStatus;
    }

    public function isDnsOnly(): bool
    {
        return $this->isDnsOnly;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setIsTransferLocked(bool $isTransferLocked): Domain
    {
        $this->isTransferLocked = $isTransferLocked;
        return $this;
    }

    public function setIsWhitelabel(bool $isWhitelabel): Domain
    {
        $this->isWhitelabel = $isWhitelabel;
        return $this;
    }

    public function setTags(array $tags): Domain
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTag(string $tag): Domain
    {
        $this->tags[] = $tag;
        $this->tags = array_unique($this->tags);
        return $this;
    }

    public function removeTag(string $tag): Domain
    {
        $this->tags = array_diff($this->getTags(), [$tag]);
        return $this;
    }

    public function getHasAutoDns(): bool
    {
        return $this->hasAutoDns;
    }

    public function setHasAutoDns(bool $hasAutoDns): void
    {
        $this->hasAutoDns = $hasAutoDns;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Nameserver[]
     */
    public function getNameservers()
    {
        return $this->nameservers;
    }

    /**
     * @param Nameserver[] $nameservers
     */
    public function setNameservers($nameservers): void
    {
        $this->nameservers = $nameservers;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Contact[] $contacts
     */
    public function setContacts($contacts): void
    {
        $this->contacts = $contacts;
    }
}
