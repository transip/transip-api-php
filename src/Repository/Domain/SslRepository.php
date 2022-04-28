<?php

namespace Transip\Api\Library\Repository\Domain;

use Transip\Api\Library\Entity\SslCertificate;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\DomainRepository;

class SslRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ssl';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [DomainRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $domainName
     * @return \Transip\Api\Library\Entity\SslCertificate[]
     */
    public function getByDomainName(string $domainName): array
    {
        $sslCertificates      = [];
        $response             = $this->httpClient->get($this->getResourceUrl($domainName));
        $sslCertificatesArray = $this->getParameterFromResponse($response, 'certificates');

        foreach ($sslCertificatesArray as $sslCertificateArray) {
            $sslCertificates[] = new \Transip\Api\Library\Entity\SslCertificate($sslCertificateArray);
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
