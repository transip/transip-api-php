<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class Backup extends AbstractEntity
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $dateTimeCreate
     */
    protected $dateTimeCreate;

    /**
     * @var string $diskSize
     */
    protected $diskSize;

    /**
     * @var string $operatingSystem
     */
    protected $operatingSystem;

    /**
     * @var string $availabilityZone
     */
    protected $availabilityZone;

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

    public function getStatus(): string
    {
        return $this->status;
    }
}
