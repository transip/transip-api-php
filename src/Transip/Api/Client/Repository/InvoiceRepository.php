<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Invoice;

class InvoiceRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'invoices';

    public function getAll(): array
    {
        $invoices   = [];
        $response   = $this->httpClient->get($this->getResourceUrl());
        $invoicesArray = $this->getParameterFromResponse($response, 'invoices');

        foreach ($invoicesArray as $invoiceArray) {
            $invoices[] = new Invoice($invoiceArray);
        }

        return $invoices;
    }

    public function getSelection(int $page, int $itemsPerPage): array
    {
        $invoices   = [];
        $query      = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response   = $this->httpClient->get($this->getResourceUrl(), $query);
        $invoicesArray = $this->getParameterFromResponse($response, 'invoices');

        foreach ($invoicesArray as $invoiceArray) {
            $invoices[] = new Invoice($invoiceArray);
        }

        return $invoices;
    }

    public function getByInvoiceNumber(string $invoiceNumber): Invoice
    {
        $response = $this->httpClient->get($this->getResourceUrl($invoiceNumber));
        $invoice  = $this->getParameterFromResponse($response, 'invoice');

        return new Invoice($invoice);
    }
}
