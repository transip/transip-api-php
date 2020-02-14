<?php

namespace Transip\Api\Library\Entity\Invoice;

use Transip\Api\Library\Entity\AbstractEntity;

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
    public $date;

    /**
     * @var int
     */
    public $quantity;

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

    public function getProduct(): string
    {
        return $this->product;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isRecurring(): bool
    {
        return $this->isRecurring;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPriceInclVat(): int
    {
        return $this->priceInclVat;
    }

    public function getVat(): int
    {
        return $this->vat;
    }

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
