<?php

namespace Transip\Api\Library\Entity\Haip;

use Transip\Api\Library\Entity\AbstractEntity;

class Certificate extends AbstractEntity
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $commonName;

    /**
     * @var string
     */
    protected $expirationDate;

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
