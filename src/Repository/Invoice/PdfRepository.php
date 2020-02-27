<?php

namespace Transip\Api\Library\Repository\Invoice;

use Transip\Api\Library\Entity\Invoice\InvoicePdf;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\InvoiceRepository;

class PdfRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'pdf';

    protected function getRepositoryResourceNames(): array
    {
        return [InvoiceRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByInvoiceNumber(string $invoiceNumber): InvoicePdf
    {
        $response = $this->httpClient->get($this->getResourceUrl($invoiceNumber));
        $pdf      = $this->getParameterFromResponse($response, self::RESOURCE_NAME);
        return new InvoicePdf([self::RESOURCE_NAME => $pdf]);
    }
}
