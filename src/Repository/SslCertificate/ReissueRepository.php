<?php

namespace Transip\Api\Library\Repository\SslCertificate;

use Transip\Api\Library\Entity\SslCertificate\Reissue;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\SslCertificateRepository;

class ReissueRepository extends ApiRepository
{
    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [SslCertificateRepository::RESOURCE_NAME];
    }

    public function reissue(int $sslCertificateId, Reissue $reissue): void
    {
        $this->httpClient->patch($this->getResourceUrl($sslCertificateId), [
            'action' => 'reissue',
            'approverFirstName' => $reissue->getApproverFirstName(),
            'approverLastName' => $reissue->getApproverLastName(),
            'approverEmail' => $reissue->getApproverEmail(),
            'approverPhone' => $reissue->getApproverPhone(),
            'address' => $reissue->getAddress(),
            'zipCode' => $reissue->getZipCode(),
            'countryCode' => $reissue->getCountryCode(),
        ]);
    }
}
