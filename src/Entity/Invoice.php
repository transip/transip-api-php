<?php

namespace Transip\Api\Library\Entity;

class Invoice extends AbstractEntity
{
    /**
     * @var string
     */
    protected $invoiceNumber;

    /**
     * @var string
     */
    protected $creationDate;

    /**
     * @var string
     */
    protected $payDate;

    /**
     * @var string
     */
    protected $dueDate;

    /**
     * @var string
     */
    protected $invoiceStatus;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var int
     */
    protected $totalAmount;

    /**
     * @var int
     */
    protected $totalAmountInclVat;

    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    /**
     * @return string
     */
    public function getPayDate(): string
    {
        return $this->payDate;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @return string
     */
    public function getInvoiceStatus(): string
    {
        return $this->invoiceStatus;
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
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * @return int
     */
    public function getTotalAmountInclVat(): int
    {
        return $this->totalAmountInclVat;
    }
}
