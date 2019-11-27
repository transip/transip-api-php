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
    public function getCommonName(): string
    {
        return $this->commonName;
    }

    /**
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }
}