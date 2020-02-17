<?php

namespace Transip\Api\Library\Entity\BigStorage;

use Transip\Api\Library\Entity\AbstractEntity;

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
     * @var int $diskSize
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

    public function getDiskSize(): int
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
