<?php

namespace Transip\Api\Client\Entity\BigStorage;

use Transip\Api\Client\Entity\AbstractEntity;

class Backup extends AbstractEntity
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $diskSize
     */
    public $diskSize;

    /**
     * @var string $dateTimeCreate
     */
    public $dateTimeCreate;

    /**
     * @var string $availabilityZone
     */
    public $availabilityZone;


    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDiskSize(): string
    {
        return $this->diskSize;
    }

    public function getDateTimeCreate(): string
    {
        return $this->dateTimeCreate;
    }

    public function getAvailabilityZone(): string
    {
        return $this->availabilityZone;
    }
}
