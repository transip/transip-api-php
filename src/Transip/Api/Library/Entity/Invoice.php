<?php

namespace Transip\Api\Library\Entity;

class Invoice extends AbstractEntity
{
    /**
     * @var string
     */
    public $invoiceNumber;

    /**
     * @var string
     */
    public $creationDate;

    /**
     * @var string
     */
    public $payDate;

    /**
     * @var string
     */
    public $dueDate;

    /**
     * @var string
     */
    public $invoiceStatus;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var int
     */
    public $totalAmount;

    /**
     * @var int
     */
    public $totalAmountInclVat;

    /**
     * @var InvoiceItem[]
     */
    public $invoiceItems;

    public function __construct(array $valueArray = [])
    {
        parent::__construct($valueArray);

        $invoiceItems     = [];
        $invoiceItemArray = $valueArray['invoiceItems'] ?? [];
        foreach ($invoiceItemArray as $invoiceItem) {
            $invoiceItems[] = new InvoiceItem($invoiceItem);
        }

        $this->invoiceItems = $invoiceItems;
    }

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

    /**
     * @return InvoiceItem[]
     */
    public function getInvoiceItems(): array
    {
        return $this->invoiceItems;
    }
}
