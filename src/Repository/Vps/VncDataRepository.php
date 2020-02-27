<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\VncData;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class VncDataRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'vnc-data';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByVpsName(string $vpsName): VncData
    {
        $response     = $this->httpClient->get($this->getResourceUrl($vpsName));
        $vncDataArray = $this->getParameterFromResponse($response, 'vncData');

        return new VncData($vncDataArray);
    }

    public function regenerateVncCredentials(string $vpsName): void
    {
        $this->httpClient->patch($this->getResourceUrl($vpsName), []);
    }
}
