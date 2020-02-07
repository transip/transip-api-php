<?php

namespace Transip\Api\Library\Repository\Invoice;

use Transip\Api\Library\Entity\Invoice\InvoiceItem;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\InvoiceRepository;

class ItemRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'invoice-items';

    protected function getRepositoryResourceNames(): array
    {
        return [InvoiceRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $invoiceNumber
     * @return InvoiceItem[]
     */
    public function getByInvoiceNumber(string $invoiceNumber): array
    {
        $invoiceitems      = [];
        $response          = $this->httpClient->get($this->getResourceUrl($invoiceNumber));
        $invoiceItemsArray = $this->getParameterFromResponse($response, 'invoiceItems');

        foreach ($invoiceItemsArray as $invoiceItemArray) {
            $invoiceitems[] = new InvoiceItem($invoiceItemArray);
        }

        return $invoiceitems;
    }
}
