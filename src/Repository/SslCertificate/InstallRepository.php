<?php

namespace Transip\Api\Library\Repository\SslCertificate;

use Transip\Api\Library\Entity\SslCertificate\Details;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\SslCertificateRepository;

class InstallRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'install';

    protected function getRepositoryResourceNames(): array
    {
        return [SslCertificateRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function installCertificate(int $sslCertificateId, string $domainName, ?string $passphrase = null): void
    {
        $params = [
            'domainName'=> $domainName,
        ];
        if ($passphrase !== null) {
            $params['passphrase'] = $passphrase;
        }

        $this->httpClient->patch($this->getResourceUrl($sslCertificateId), $params);
    }
}
