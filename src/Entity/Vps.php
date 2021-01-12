<?php

namespace Transip\Api\Library\Entity;

class Vps extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $uuid
     */
    protected $uuid;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $productName
     */
    protected $productName;

    /**
     * @var string $operatingSystem
     */
    protected $operatingSystem;

    /**
     * @var int $diskSize
     */
    protected $diskSize;

    /**
     * @var int $memorySize
     */
    protected $memorySize;

    /**
     * @var int $cpus
     */
    protected $cpus;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $ipAddress
     */
    protected $ipAddress;

    /**
     * @var string $macAddress
     */
    protected $macAddress;

    /**
     * @var int $currentSnapshots
     */
    protected $currentSnapshots;

    /**
     * @var int $maxSnapshots
     */
    protected $maxSnapshots;

    /**
     * @var bool $isLocked
     */
    protected $isLocked;

    /**
     * @var bool $isBlocked
     */
    protected $isBlocked;

    /**
     * @var bool $isCustomerLocked
     */
    protected $isCustomerLocked;

    /**
     * @var string $availabilityZone
     */
    protected $availabilityZone;

    /**
     * @var array
     */
    protected $tags;

    public function getName(): string
    {
        return $this->name;
    }

    public function getUuid(): string
    {
        return $this->uuid;
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
