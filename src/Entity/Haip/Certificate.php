<?php

namespace Transip\Api\Library\Entity\Haip;

use Transip\Api\Library\Entity\AbstractEntity;

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

    public function getId(): string
    {
        return $this->id;
    }

    public function getCommonName(): string
    {
        return $this->commonName;
    }

    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }
}
