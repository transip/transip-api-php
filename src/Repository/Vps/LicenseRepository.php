<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\License;
use Transip\Api\Library\Entity\Vps\LicenseProduct;
use Transip\Api\Library\Entity\Vps\Licenses;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class LicenseRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'licenses';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getByVpsName(string $vpsName): Licenses
    {
        $response      = $this->httpClient->get($this->getResourceUrl($vpsName));
        $licencesArray = $this->getParameterFromResponse($response, 'licenses');

        $struct = [];
        foreach ($licencesArray as $licenseType => $licenses) {
            foreach ($licenses as $license) {
                if ($licenseType === 'available') {
                    $struct[$licenseType][] = new LicenseProduct($license);
                    continue;
                }

                $struct[$licenseType][] = new License($license);
            }
        }

        return new Licenses($struct);
    }

    public function order(string $vpsName, string $licenseName, int $quantity): void
    {
        $parameters = [
            'licenseName' => $licenseName,
            'quantity' => $quantity,
        ];

        $this->httpClient->post($this->getResourceUrl($vpsName), $parameters);
    }

    public function update(string $vpsName, int $licenseId, string $newLicenseName): void
    {
        $this->httpClient->put($this->getResourceUrl($vpsName, $licenseId), ['newLicenseName' => $newLicenseName]);
    }

    public function cancel(string $vpsName, int $licenseId): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName, $licenseId));
    }
}
