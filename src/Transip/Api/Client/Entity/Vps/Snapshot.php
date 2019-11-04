<?php

namespace Transip\Api\Client\Entity\Vps;

use Transip\Api\Client\Entity\AbstractEntity;

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
}
