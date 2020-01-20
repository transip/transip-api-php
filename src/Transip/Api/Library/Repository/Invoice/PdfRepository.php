<?php

namespace Transip\Api\Library\Repository\Invoice;

use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\InvoiceRepository;

class PdfRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'pdf';

    protected function getRepositoryResourceNames(): array
    {
        return [InvoiceRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByInvoiceNumber(string $invoiceNumber): string
    {
        $response = $this->httpClient->get($this->getResourceUrl($invoiceNumber));
        return $this->getParameterFromResponse($response, self::RESOURCE_NAME);
    }
}
