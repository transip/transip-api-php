<?php

namespace Transip\Api\Client\Entity\Vps;

use Transip\Api\Client\Entity\AbstractEntity;

class Backup extends AbstractEntity
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $dateTimeCreate
     */
    public $dateTimeCreate;

    /**
     * @var string $diskSize
     */
    public $diskSize;

    /**
     * @var string $operatingSystem
     */
    public $operatingSystem;

    /**
     * @var string $availabilityZone
     */
    public $availabilityZone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDateTimeCreate(): string
    {
        return $this->dateTimeCreate;
    }

    public function getDiskSize(): string
    {
        return $this->diskSize;
    }

    public function getOperatingSystem(): string
    {
        return $this->operatingSystem;
    }

    public function getAvailabilityZone(): string
    {
        return $this->availabilityZone;
    }
}
