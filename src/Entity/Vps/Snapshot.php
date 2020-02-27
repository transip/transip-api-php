<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class Snapshot extends AbstractEntity
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
     * @var string $dateTimeCreate
     */
    protected $dateTimeCreate;

    /**
     * @var string $diskSize
     */
    protected $diskSize;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $operatingSystem
     */
    protected $operatingSystem;

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
