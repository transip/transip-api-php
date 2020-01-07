<?php

namespace Transip\Api\Client\Repository\Domain;

use Transip\Api\Client\Entity\Domain\SslCertificate;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\DomainRepository;

class SslRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ssl';

    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return SslCertificate[]
     */
    public function getByDomainName(string $domainName): array
    {
        $sslCertificates      = [];
        $response             = $this->httpClient->get($this->getResourceUrl($domainName));
        $sslCertificatesArray = $this->getParameterFromResponse($response, 'certificates');

        foreach ($sslCertificatesArray as $sslCertificateArray) {
            $sslCertificates[] = new SslCertificate($sslCertificateArray);
        }

        return $sslCertificates;
    }

    public function getByDomainNameCertificateId(string $domainName, int $certificateId): SslCertificate
    {
        $response    = $this->httpClient->get($this->getResourceUrl($domainName, $certificateId));
        $certificate = $this->getParameterFromResponse($response, 'certificate');

        return new SslCertificate($certificate);
    }
}
