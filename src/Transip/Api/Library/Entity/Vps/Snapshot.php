<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class Snapshot extends AbstractEntity
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
     * @var string $dateTimeCreate
     */
    public $dateTimeCreate;

    /**
     * @var string $diskSize
     */
    public $diskSize;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $operatingSystem
     */
    public $operatingSystem;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDateTimeCreate(): string
    {
        return $this->dateTimeCreate;
    }

    public function getDiskSize(): string
    {
        return $this->diskSize;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOperatingSystem(): string
    {
        return $this->operatingSystem;
    }
}
