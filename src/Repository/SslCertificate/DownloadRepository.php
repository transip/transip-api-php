<?php

namespace Transip\Api\Library\Repository\SslCertificate;

use Transip\Api\Library\Entity\SslCertificate\CertificateData;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\SslCertificateRepository;

class DownloadRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'download';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [SslCertificateRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function download(int $sslCertificateId): CertificateData
    {
        $response = $this->httpClient->post($this->getResourceUrl($sslCertificateId));
        $certificateDataArray = $this->getParameterFromResponse($response, 'certificateData');

        return new CertificateData($certificateDataArray);
    }
}
