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
     * @var float $renewalPrice
     */
    public $renewalPrice;

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

    public function getRenewalPrice(): float
    {
        return $this->renewalPrice;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
