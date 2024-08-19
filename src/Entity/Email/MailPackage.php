<?php

namespace Transip\Api\Library\Entity\Email;

use Transip\Api\Library\Entity\AbstractEntity;

class MailPackage extends AbstractEntity
{
    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $status;

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
