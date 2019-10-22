<?php

namespace Transip\Api\Client\Entity;

class Vps extends AbstractEntity
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
     * @var string $productType
     */
    public $productType;

    /**
     * @var int $productPrice
     */
    public $productPrice;

    /**
     * @var string $operatingSystem
     */
    public $operatingSystem;

    /**
     * @var int $diskSize
     */
    public $diskSize;

    /**
     * @var int $memorySize
     */
    public $memorySize;

    /**
     * @var int $cpus
     */
    public $cpus;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $ipAddress
     */
    public $ipAddress;

    /**
     * @var string $macAddress
     */
    public $macAddress;

    /**
     * @var int $currentSnapshots
     */
    public $currentSnapshots;

    /**
     * @var int $maxSnapshots
     */
    public $maxSnapshots;

    /**
     * @var bool $isLocked
     */
    public $isLocked;

    /**
     * @var bool $isBlocked
     */
    public $isBlocked;

    /**
     * @var bool $isCustomerLocked
     */
    public $isCustomerLocked;

    /**
     * @var string $availabilityZone
     */
    public $availabilityZone;
}
