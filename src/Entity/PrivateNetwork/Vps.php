<?php

namespace Transip\Api\Library\Entity\PrivateNetwork;

use Transip\Api\Library\Entity\AbstractEntity;

class Vps extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $uuid
     */
    protected $uuid;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $macAddress
     */
    protected $macAddress;

    /**
     * @var bool $isLocked
     */
    protected $isLocked;

    /**
     * @var bool $isBlocked
     */
    protected $isBlocked;

    /**
     * @var bool $isCustomerLocked
     */
    protected $isCustomerLocked;

    public function getName(): string
    {
        return $this->name;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function isCustomerLocked(): bool
    {
        return $this->isCustomerLocked;
    }
}
