<?php

namespace Transip\Api\Library\Entity;

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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
