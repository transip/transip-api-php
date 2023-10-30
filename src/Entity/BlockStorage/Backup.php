<?php

namespace Transip\Api\Library\Entity\BlockStorage;

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
     * @var int $size
     */
    protected $size;

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

    public function getSize(): int
    {
        return $this->size;
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
