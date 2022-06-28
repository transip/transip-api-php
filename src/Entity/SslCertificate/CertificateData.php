<?php

namespace Transip\Api\Library\Entity\SslCertificate;

use Transip\Api\Library\Entity\AbstractEntity;

class CertificateData extends AbstractEntity
{
    /**
     * @var string
     */
    public $caBundleCrt;

    /**
     * @var string
     */
    public $certificateCrt;

    /**
     * @var string
     */
    public $certificateP7b;

    /**
     * @var string
     */
    public $certificateKey;

    /**
     * @return string
     */
    public function getCaBundleCrt(): string
    {
        return $this->caBundleCrt;
    }

    /**
     * @return string
     */
    public function getCertificateCrt(): string
    {
        return $this->certificateCrt;
    }

    /**
     * @return string
     */
    public function getCertificateP7b(): string
    {
        return $this->certificateP7b;
    }

    /**
     * @return string
     */
    public function getCertificateKey(): string
    {
        return $this->certificateKey;
    }
}
