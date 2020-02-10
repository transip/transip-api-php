<?php

namespace Transip\Api\Library\Entity\Invoice;

use Transip\Api\Library\Entity\AbstractEntity;

class InvoiceItemDiscount extends AbstractEntity
{
    /**
     * @var string
     */
    public $description;
    /**
     * @var int
     */
    public $amount;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
