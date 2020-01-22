<?php

namespace Transip\Api\Library\Entity;

class Vps extends AbstractEntity
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $productName
     */
    public $productName;

    /**
     * @var string $operatingSystem
     */
    public $operatingSystem;

    /**
     * @var int $diskSize
     */
    public $diskSize;

    /**
     * @var int $memorySize
     */
    public $memorySize;

    /**
     * @var int $cpus
     */
    public $cpus;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $ipAddress
     */
    public $ipAddress;

    /**
     * @var string $macAddress
     */
    public $macAddress;

    /**
     * @var int $currentSnapshots
     */
    public $currentSnapshots;

    /**
     * @var int $maxSnapshots
     */
    public $maxSnapshots;

    /**
     * @var bool $isLocked
     */
    public $isLocked;

    /**
     * @var bool $isBlocked
     */
    public $isBlocked;

    /**
     * @var bool $isCustomerLocked
     */
    public $isCustomerLocked;

    /**
     * @var string $availabilityZone
     */
    public $availabilityZone;

    /**
     * @var array
     */
    public $tags;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getOperatingSystem(): string
    {
        return $this->operatingSystem;
    }

    public function getDiskSize(): int
    {
        return $this->diskSize;
    }

    public function getMemorySize(): int
    {
        return $this->memorySize;
    }

    public function getCpus(): int
    {
        return $this->cpus;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    public function getCurrentSnapshots(): int
    {
        return $this->currentSnapshots;
    }

    public function getMaxSnapshots(): int
    {
        return $this->maxSnapshots;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function isCustomerLocked(): bool
    {
        return $this->isCustomerLocked;
    }

    public function getAvailabilityZone(): string
    {
        return $this->availabilityZone;
    }

    public function setDescription(string $description): Vps
    {
        $this->description = $description;
        return $this;
    }

    public function setIsCustomerLocked(bool $isCustomerLocked): void
    {
        $this->isCustomerLocked = $isCustomerLocked;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function addTag(string $tag): Vps
    {
        $this->tags[] = $tag;
        $this->tags = array_unique($this->tags);
        return $this;
    }

    public function removeTag(string $tag): Vps
    {
        $this->tags = array_diff($this->getTags(), [$tag]);
        return $this;
    }
}
