<?php

namespace Transip\Api\Library\Entity\Product;

use Transip\Api\Library\Entity\AbstractEntity;

class Element extends AbstractEntity
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
     * @var int $amount
     */
    protected $amount;

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
