<?php

namespace Transip\Api\Library\Repository\SslCertificate;

use Transip\Api\Library\Entity\SslCertificate\Details;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\SslCertificateRepository;

class DetailsRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'details';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [SslCertificateRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    public function getBySslCertificateId(int $sslCertificateId): Details
    {
        $response = $this->httpClient->get($this->getResourceUrl($sslCertificateId));
        $detailsArray = $this->getParameterFromResponse($response, 'certificateDetails');

        return new Details($detailsArray);
    }
}
