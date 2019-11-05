<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Product;
use Transip\Api\Client\Repository\ApiRepository;

class AddonRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vps', 'addons'];
    }

    /**
     * @param string $vpsName
     * @return Product[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $addons        = [];
        $response      = $this->httpClient->get($this->getResourceUrl($vpsName));
        $categoryArray = $response['addons'] ?? [];

        foreach ($categoryArray as $category => $addonsArray) {
            foreach ($addonsArray as $addonArray) {
                $addonArray['category'] = $category;
                $addons[]               = new Product($addonArray);
            }
        }

        return $addons;
    }

    public function order(string $vpsName, array $addonNames): void
    {
        $parameters['addons'] = $addonNames;
        $this->httpClient->post($this->getResourceUrl($vpsName), $parameters);
    }

    public function cancel(string $vpsName, string $addonName): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName, $addonName), []);
    }
}
