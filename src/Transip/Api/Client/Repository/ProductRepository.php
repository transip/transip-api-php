<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Product;

class ProductRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'products';

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        $products      = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $categoryArray = $this->getParameterFromResponse($response, 'products');

        foreach ($categoryArray as $category => $productsArray) {
            foreach ($productsArray as $productArray) {
                $productArray['category'] = $category;
                $products[] = new Product($productArray);
            }
        }

        return $products;
    }
}
