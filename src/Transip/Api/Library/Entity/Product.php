<?php

namespace Transip\Api\Library\Entity;

class Product extends AbstractEntity
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
     * @var int $price
     */
    public $price;

    /**
     * @var int $recurringPrice
     */
    public $recurringPrice;

    /**
     * @var string $category
     */
    public $category;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getRecurringPrice(): int
    {
        return $this->recurringPrice;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
