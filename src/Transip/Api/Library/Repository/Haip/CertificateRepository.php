<?php

namespace Transip\Api\Library\Repository\Haip;

use Transip\Api\Library\Entity\Haip\Certificate;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\HaipRepository;

class CertificateRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'certificates';

    protected function getRepositoryResourceNames(): array
    {
        return [HaipRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $haipName
     * @return Certificate[]
     */
    public function getByHaipName(string $haipName): array
    {
        $certificates     = [];
        $response         = $this->httpClient->get($this->getResourceUrl($haipName));
        $certificateArray = $this->getParameterFromResponse($response, 'certificates');

        foreach ($certificateArray as $certificateStruct) {
            $certificates[] = new Certificate($certificateStruct);
        }

        return $certificates;
    }

    public function addBySslCertificateId(string $haipName, int $sslCertificateId): void
    {
        $url = $this->getResourceUrl($haipName);

        $this->httpClient->post($url, ['sslCertificateId' => $sslCertificateId]);
    }

    public function addByCommonName(string $haipName, string $commonName): void
    {
        $url = $this->getResourceUrl($haipName);

        $this->httpClient->post($url, ['commonName' => $commonName]);
    }

    public function delete(string $haipName, int $haipCertificateId): void
    {
        $url = $this->getResourceUrl($haipName, $haipCertificateId);

        $this->httpClient->delete($url);
    }
}
