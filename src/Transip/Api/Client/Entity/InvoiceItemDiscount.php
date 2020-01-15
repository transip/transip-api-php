<?php

namespace Transip\Api\Client\Entity;

class InvoiceItemDiscount extends AbstractEntity
{

    /**
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    public $isRecurring;

    /**
     * @var string
     */
    public $discountDate;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var int
     */
    public $price;

    /**
     * @var int
     */
    public $vat;

    /**
     * @var int
     */
    public $priceInclVat;

    /**
     * @var int
     */
    public $vatPercentage;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isRecurring(): bool
    {
        return $this->isRecurring;
    }

    /**
     * @return string
     */
    public function getDiscountDate(): string
    {
        return $this->discountDate;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getVat(): int
    {
        return $this->vat;
    }

    /**
     * @return int
     */
    public function getPriceInclVat(): int
    {
        return $this->priceInclVat;
    }

    /**
     * @return int
     */
    public function getVatPercentage(): int
    {
        return $this->vatPercentage;
    }
}
