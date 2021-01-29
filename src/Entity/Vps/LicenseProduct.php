<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class LicenseProduct extends AbstractEntity
{
    /** @var string */
    protected $name;

    /** @var int */
    protected $price;

    /** @var int */
    protected $recurringPrice;

    /** @var string */
    protected $type;

    /** @var int */
    protected $maxQuantity;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getRecurringPrice(): int
    {
        return $this->recurringPrice;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMaxQuantity(): int
    {
        return $this->maxQuantity;
    }
}
