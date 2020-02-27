<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Product;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

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
        $upgradesArray = $this->getParameterFromResponse($response, 'upgrades');

        foreach ($upgradesArray as $upgradeArray) {
            $upgradeArray['category'] = 'vps';
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
