<?php

namespace Transip\Api\Library\Repository\Kubernetes;

use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Entity\Kubernetes\Product as KubernetesProduct;

class ProductRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kubernetes/products';

    public const RESOURCE_PARAMETER_SINGULAR = 'product';
    public const RESOURCE_PARAMETER_PLURAL   = 'products';

    /**
     * @return KubernetesProduct[]
     */
    public function getAll(): array
    {
        return $this->getProducts();
    }

    /**
     * @param string[] $types
     * @return KubernetesProduct[]
     */
    public function getByTypes(array $types): array
    {
        return $this->getProducts($types);
    }

    /**
     * @param string[] $types
     * @return KubernetesProduct[]
     */
    private function getProducts(array $types = []): array
    {
        $query['types'] = implode(',', $types);
        $response = $this->httpClient->get($this->getResourceUrl(), $query);

        $productsArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);
        $products = [];

        foreach ($productsArray as $productArray) {
            $products[] = new KubernetesProduct($productArray);
        }

        return $products;
    }

    public function getByName(string $name): KubernetesProduct
    {
        $response = $this->httpClient->get($this->getResourceUrl($name));

        return new KubernetesProduct($this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR));
    }
}
