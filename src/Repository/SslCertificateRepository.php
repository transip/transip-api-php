<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\SslCertificate;

class SslCertificateRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ssl-certificates';

    /**
     * @return SslCertificate[]
     */
    public function getAll(): array
    {
        $sshKeys       = [];
        $response      = $this->httpClient->get($this->getResourceUrl());
        $sshKeysArray = $this->getParameterFromResponse($response, 'certificates');

        foreach ($sshKeysArray as $sshKeyArray) {
            $sshKeys[] = new SslCertificate($sshKeyArray);
        }

        return $sshKeys;
    }

    public function getSelection(int $page, int $itemsPerPage): array
    {
        $query        = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response     = $this->httpClient->get($this->getResourceUrl(), $query);
        $sslCertificatesArray = $this->getParameterFromResponse($response, 'certificates');

        $sslCertificates = [];
        foreach ($sslCertificatesArray as $sslCertificateArray) {
            $sslCertificates[] = new SslCertificate($sslCertificateArray);
        }

        return $sslCertificates;
    }

    public function getById(string $sshKeyId): SslCertificate
    {
        $response    = $this->httpClient->get($this->getResourceUrl($sshKeyId));
        $sshKeyArray = $this->getParameterFromResponse($response, 'certificate');

        return new SslCertificate($sshKeyArray);
    }
}
