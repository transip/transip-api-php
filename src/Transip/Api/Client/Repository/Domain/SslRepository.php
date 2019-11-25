<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\SslCertificate;
use Transip\Api\Client\Repository\ApiRepository;

class SslRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['domains', 'ssl'];
    }

    /**
     * @param string $domainName
     * @return SslCertificate[]
     */
    public function getByDomainName(string $domainName): array
    {
        $sslCertificates      = [];
        $response             = $this->httpClient->get($this->getResourceUrl($domainName));
        $sslCertificatesArray = $response['certificates'] ?? [];

        foreach ($sslCertificatesArray as $sslCertificateArray) {
            $sslCertificates[] = new SslCertificate($sslCertificateArray);
        }

        return $sslCertificates;
    }

    public function getByDomainNameCertificateId(string $domainName, int $certificateId): SslCertificate
    {
        $response = $this->httpClient->get($this->getResourceUrl($domainName, $certificateId));
        $certificate = $response['certificate'] ?? null;
        return new SslCertificate($certificate);
    }
}
