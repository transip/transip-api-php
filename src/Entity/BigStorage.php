<?php

namespace Transip\Api\Library\Entity;

class BigStorage extends AbstractEntity
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
     * @var int $diskSize
     */
    public $diskSize;

    /**
     * @var string $vpsName
     */
    public $vpsName;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var bool $isLocked
     */
    public $isLocked;

    /**
     * @var string $availabilityZone
     */
    public $availabilityZone;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDiskSize(): int
    {
        return $this->diskSize;
    }

    public function getVpsName(): string
    {
        return $this->vpsName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function getAvailabilityZone(): string
    {
        return $this->availabilityZone;
    }

    public function setDescription(string $description): BigStorage
    {
        $this->description = $description;
        return $this;
    }

    public function setVpsName(string $vpsName): BigStorage
    {
        $this->vpsName = $vpsName;
        return $this;
    }
}
