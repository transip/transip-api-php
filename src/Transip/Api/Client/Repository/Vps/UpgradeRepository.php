<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Product;
use Transip\Api\Client\Repository\ApiRepository;

class UpgradeRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vps', 'upgrades'];
    }

    /**
     * @param string $vpsName
     * @return Product[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $operatingSystems      = [];
        $response              = $this->httpClient->get($this->getResourceUrl($vpsName));
        $operatingSystemsArray = $response['upgrades'] ?? [];

        foreach ($operatingSystemsArray as $operatingSystemArray) {
            $operatingSystems[] = new Product($operatingSystemArray);
        }

        return $operatingSystems;
    }

    public function upgrade(string $vpsName, string $productName): void
    {
        $parameters['productName'] = $productName;
        $this->httpClient->post($this->getResourceUrl($vpsName), $parameters);
    }
}
