<?php

namespace Transip\Api\Client\Entity;

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
     * @var float $price
     */
    public $price;

    /**
     * @var float $recurringPrice
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getRecurringPrice(): float
    {
        return $this->recurringPrice;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
