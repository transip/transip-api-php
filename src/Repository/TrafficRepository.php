<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\TrafficInformation;

/**
 * @deprecated deprecated since version 6.8.0, use trafficPool instead
 */
class TrafficRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'traffic';

    public function getTrafficPool(): TrafficInformation
    {
        return $this->getByVpsName('');
    }

    public function getByVpsName(string $vpsName): TrafficInformation
    {
        $response           = $this->httpClient->get($this->getResourceUrl($vpsName));
        $trafficInformation = $this->getParameterFromResponse($response, 'trafficInformation');

        return new TrafficInformation($trafficInformation);
    }
}
