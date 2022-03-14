<?php

namespace Transip\Api\Library\Entity\Email;

use Transip\Api\Library\Entity\AbstractEntity;

class Mailbox extends AbstractEntity
{
    /**
     * @var string $identifier
     */
    public $identifier;

    /**
     * @var string $localPart
     */
    public $localPart;

    /**
     * @var string $domain
     */
    public $domain;

    /**
     * @var string $forwardTo
     */
    public $forwardTo;

    /**
     * @var int $availableDiskSpace
     */
    public $availableDiskSpace;

    /**
     * @var float $usedDiskSpace
     */
    public $usedDiskSpace;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var bool $isLocked
     */
    public $isLocked;

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getLocalPart(): string
    {
        return $this->localPart;
    }

    /**
     * @param string $localPart
     */
    public function setLocalPart(string $localPart): void
    {
        $this->localPart = $localPart;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getForwardTo(): string
    {
        return $this->forwardTo;
    }

    /**
     * @param string $forwardTo
     */
    public function setForwardTo(string $forwardTo): void
    {
        $this->forwardTo = $forwardTo;
    }

    /**
     * @return int
     */
    public function getAvailableDiskSpace(): int
    {
        return $this->availableDiskSpace;
    }

    /**
     * @param int $availableDiskSpace
     */
    public function setAvailableDiskSpace(int $availableDiskSpace): void
    {
        $this->availableDiskSpace = $availableDiskSpace;
    }

    /**
     * @return float
     */
    public function getUsedDiskSpace(): float
    {
        return $this->usedDiskSpace;
    }

    /**
     * @param float $usedDiskSpace
     */
    public function setUsedDiskSpace(float $usedDiskSpace): void
    {
        $this->usedDiskSpace = $usedDiskSpace;
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
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    /**
     * @param bool $isLocked
     */
    public function setIsLocked(bool $isLocked): void
    {
        $this->isLocked = $isLocked;
    }
}
