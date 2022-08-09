<?php

namespace Transip\Api\Library\Repository;

use Exception;
use Transip\Api\Library\Entity\SslCertificate;
use Transip\Api\Library\Entity\SslCertificate\CertificateRequestData;

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

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return SslCertificate[]
     */
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

    public function getById(string $certificateId): SslCertificate
    {
        $response    = $this->httpClient->get($this->getResourceUrl($certificateId));
        $sshKeyArray = $this->getParameterFromResponse($response, 'certificate');

        return new SslCertificate($sshKeyArray);
    }

    public function order(string $productName, string $commonName, CertificateRequestData $data): void
    {
        if (!$data->isValid()) {
            throw new Exception('Submitted CertificateRequestData is invalid');
        }

        $body = $data->toArray();

        $this->httpClient->post($this->getResourceUrl(), $body);
    }

    public function reissue(string $certificateId, CertificateRequestData $data): void
    {
        if (!$data->isValid()) {
            throw new Exception('Submitted CertificateRequestData is invalid');
        }

        $body = $data->toArray();
        $body['action'] = 'reissue';

        $this->httpClient->patch($this->getResourceUrl($certificateId), $body);
    }
}
