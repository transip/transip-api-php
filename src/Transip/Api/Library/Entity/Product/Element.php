<?php

namespace Transip\Api\Library\Entity\Product;

use Transip\Api\Library\Entity\AbstractEntity;

class Element extends AbstractEntity
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
     * @var int $amount
     */
    public $amount;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
