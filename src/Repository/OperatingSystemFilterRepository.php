<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Vps\OperatingSystem;
use Transip\Api\Library\Exception\ApiClientException;

class OperatingSystemFilterRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'operating-systems';

    /**
     *
     * @param string $productName
     * @param string[] $addons
     * @return OperatingSystem[]
     */
    public function getAll(string $productName, array $addons): array
    {
        $query = [
            "productName" => $productName,
            "addons" => implode(",", $addons)
        ];

        $operatingSystems      = [];
        $response              = $this->httpClient->get($this->getResourceUrl(), $query);
        $operatingSystemsArray = $this->getParameterFromResponse($response, 'operatingSystems');

        foreach ($operatingSystemsArray as $operatingSystemArray) {
            $operatingSystems[] = new OperatingSystem($operatingSystemArray);
        }

        return $operatingSystems;
    }
}
