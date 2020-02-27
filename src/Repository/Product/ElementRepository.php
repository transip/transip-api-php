<?php

namespace Transip\Api\Library\Repository\Product;

use Transip\Api\Library\Entity\Product\Element as ProductElement;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\ProductRepository;

class ElementRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'elements';

    protected function getRepositoryResourceNames(): array
    {
        return [ProductRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $productName
     * @return ProductElement[]
     */
    public function getByProductName(string $productName): array
    {
        $productElements      = [];
        $response             = $this->httpClient->get($this->getResourceUrl($productName));
        $productElementsArray = $this->getParameterFromResponse($response, 'productElements');

        foreach ($productElementsArray as $productElementArray) {
            $productElements[] = new ProductElement($productElementArray);
        }

        return $productElements;
    }
}
