<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Product;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\VpsRepository;

class UpgradeRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'upgrades';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return Product[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $products      = [];
        $response      = $this->httpClient->get($this->getResourceUrl($vpsName));
        $upgradesArray = $response['upgrades'] ?? [];

        foreach ($upgradesArray as $upgradeArray) {
            $products[] = new Product($upgradeArray);
        }

        return $products;
    }

    public function upgrade(string $vpsName, string $productName): void
    {
        $parameters['productName'] = $productName;
        $this->httpClient->post($this->getResourceUrl($vpsName), $parameters);
    }
}
