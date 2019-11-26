<?php

namespace Transip\Api\Client\Repository\Haip;

use Transip\Api\Client\Entity\Haip\PortConfiguration;
use Transip\Api\Client\Repository\ApiRepository;

class CertificateRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['haips', 'certificates'];
    }

    /**
     * @param string $haipName
     * @return Certificate[]
     */
    public function getByHaipName(string $haipName): array
    {
        $certificates = [];
        $response           = $this->httpClient->get($this->getResourceUrl($haipName));
        $certificateArray   = $response['certificates'] ?? [];

        foreach ($certificateArray as $certificateStruct) {
            $certificates[] = new Certificate($certificateStruct);
        }

        return $certificates;
    }

    public function add(string $haipName, $sslCertificateId): void
    {
        $url = $this->getResourceUrl($haipName);

        $this->httpClient->post($url, ['sslCertificateId' => $sslCertificateId]);
    }

    public function delete(string $haipName, int $haipCertificateId): void
    {
        $url = $this->getResourceUrl($haipName, $haipCertificateId);

        $this->httpClient->delete($url, []);
    }
}
