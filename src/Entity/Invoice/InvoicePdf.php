<?php

namespace Transip\Api\Library\Entity\Invoice;

use Transip\Api\Library\Entity\AbstractEntity;

class InvoicePdf extends AbstractEntity
{
    /**
     * @var string
     */
    protected $pdf;

    public function getBase64Encoded(): string
    {
        return $this->pdf;
    }

    public function getPdf(): string
    {
        return base64_decode($this->pdf);
    }
}
