<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

class SslCertificate extends AbstractEntity
{
    /**
     * @var int $certificateId
     */
    public $certificateId;

    /**
     * @var string $commonName
     */
    public $commonName;

    /**
     * @var string $expirationDate
     */
    public $expirationDate;

    /**
     * @var string $status
     */
    public $status;

    public function getCertificateId(): int
    {
        return $this->certificateId;
    }

    public function getCommonName(): string
    {
        return $this->commonName;
    }

    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
