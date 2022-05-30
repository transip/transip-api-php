<?php

namespace Transip\Api\Library\Repository\SslCertificate;

use Transip\Api\Library\Entity\SslCertificate\Details;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\SslCertificateRepository;

class UninstallRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'uninstall';

    protected function getRepositoryResourceNames(): array
    {
        return [SslCertificateRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function uninstallCertificate(int $sslCertificateId, string $domainName): void
    {
        $params = [
            'domainName' => $domainName,
        ];

        $this->httpClient->delete($this->getResourceUrl($sslCertificateId), $params);
    }
}
