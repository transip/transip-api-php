<?php

namespace Transip\Api\Library\Entity\Invoice;

use Transip\Api\Library\Entity\AbstractEntity;

class InvoiceItem extends AbstractEntity
{
    /**
     * @var string
     */
    protected $product;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $isRecurring;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $priceInclVat;

    /**
     * @var int
     */
    protected $vat;

    /**
     * @var int
     */
    protected $vatPercentage;

    /**
     * @var InvoiceItemDiscount[]
     */
    protected $discounts;

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
