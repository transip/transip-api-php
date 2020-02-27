<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

class SslCertificate extends AbstractEntity
{
    /**
     * @var int $certificateId
     */
    protected $certificateId;

    /**
     * @var string $commonName
     */
    protected $commonName;

    /**
     * @var string $expirationDate
     */
    protected $expirationDate;

    /**
     * @var string $status
     */
    protected $status;

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
