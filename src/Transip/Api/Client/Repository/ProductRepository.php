<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\Product;

class ProductRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['products'];
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        $products      = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $categoryArray = $response['products'] ?? [];

        foreach ($categoryArray as $category => $productsArray) {
            foreach ($productsArray as $productArray) {
                $productArray['category'] = $category;
                $products[] = new Product($productArray);
            }
        }

        return $products;
    }
}
