<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\RescueImage;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class RescueImageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'rescue-images';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return RescueImage[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $rescueImages       = [];
        $response           = $this->httpClient->get($this->getResourceUrl($vpsName));
        $rescueImagesArray  = $this->getParameterFromResponse($response, 'rescueImages');

        foreach ($rescueImagesArray as $rescueImage) {
            $rescueImages[] = new RescueImage($rescueImage);
        }

        return $rescueImages;
    }

    /**
     * @param string $vpsName
     * @param string $rescueImageName
     * @return void
     */
    public function bootRescueImage(string $vpsName, string $rescueImageName): void
    {
        $url = $this->getResourceUrl($vpsName);
        $this->httpClient->patch($url, ['name' => $rescueImageName]);
    }
}
