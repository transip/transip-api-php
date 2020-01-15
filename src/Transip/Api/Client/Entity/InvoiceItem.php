<?php

namespace Transip\Api\Client\Entity;

class InvoiceItem extends AbstractEntity
{
    /**
     * @var string
     */
    public $product;

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
    public $invoiceItemDate;

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
    public $priceInclVat;

    /**
     * @var int
     */
    public $vat;

    /**
     * @var int
     */
    public $vatPercentage;

    /**
     * @var InvoiceItemDiscount[]
     */
    public $discounts;

    public function __construct(array $valueArray = [])
    {
        parent::__construct($valueArray);

        $itemDiscounts = [];
        $itemDiscountsArray = $valueArray['discounts'] ?? [];
        foreach ($itemDiscountsArray as $itemDiscount) {
            $itemDiscounts[] = new InvoiceItemDiscount($itemDiscount);
        }

        $this->discounts = $itemDiscounts;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

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
    public function getInvoiceItemDate(): string
    {
        return $this->invoiceItemDate;
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
    public function getPriceInclVat(): int
    {
        return $this->priceInclVat;
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
    public function getVatPercentage(): int
    {
        return $this->vatPercentage;
    }

    /**
     * @return InvoiceItemDiscount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }
}
