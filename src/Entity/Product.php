<?php

namespace Transip\Api\Library\Entity;

class Product extends AbstractEntity
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
     * @var int $price
     */
    protected $price;

    /**
     * @var int $recurringPrice
     */
    protected $recurringPrice;

    /**
     * @var string $category
     */
    protected $category;

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
