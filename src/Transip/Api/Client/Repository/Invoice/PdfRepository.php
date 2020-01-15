<?php

namespace Transip\Api\Client\Repository\Invoice;

use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\InvoiceRepository;

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
