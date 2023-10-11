<?php

namespace Transip\Api\Library\Entity;

class BlockStorage extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var int $diskSize
     */
    protected $diskSize;

    /**
     * @var string $vpsName
     */
    protected $vpsName;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var bool $isLocked
     */
    protected $isLocked;

    /**
     * @var string $availabilityZone
     */
    protected $availabilityZone;

    /**
     * @var string $productType
     */
    protected $productType;

    /**
     * @var string $serial
     */
    protected $serial;

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

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function setDescription(string $description): BlockStorage
    {
        $this->description = $description;
        return $this;
    }

    public function setVpsName(string $vpsName): BlockStorage
    {
        $this->vpsName = $vpsName;
        return $this;
    }

    public function getSerial(): string
    {
        return $this->serial;
    }
}
