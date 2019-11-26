<?php

namespace Transip\Api\Client\Entity\Haip;

use Transip\Api\Client\Entity\AbstractEntity;

class Certificate extends AbstractEntity
{

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $sslCertificateId;

    /**
     * @var string
     */
    public $commonName;

    /**
     * @var string
     */
    public $expirationDate;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSslCertificateId(): string
    {
        return $this->sslCertificateId;
    }

    /**
     * @return string
     */
    public function getCommonName(): string
    {
        return $this->commonName;
    }

    /**
     * @param string $commonName
     */
    public function setCommonName(string $commonName): void
    {
        $this->commonName = $commonName;
    }

    /**
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    /**
     * @param string $expirationDate
     */
    public function setExpirationDate(string $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }
}