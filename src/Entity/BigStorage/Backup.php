<?php

namespace Transip\Api\Library\Entity\BigStorage;

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
     * @var int $diskSize
     */
    protected $diskSize;

    /**
     * @var string $dateTimeCreate
     */
    protected $dateTimeCreate;

    /**
     * @var string $availabilityZone
     */
    protected $availabilityZone;


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
