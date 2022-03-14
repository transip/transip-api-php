<?php

namespace Transip\Api\Library\Entity\Email;

use Transip\Api\Library\Entity\AbstractEntity;

class MailForward extends AbstractEntity
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $localPart
     */
    public $localPart;

    /**
     * @var string $domain
     */
    public $domain;

    /**
     * @var string $forwardTo
     */
    public $forwardTo;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLocalPart(): string
    {
        return $this->localPart;
    }

    /**
     * @param string $localPart
     */
    public function setLocalPart(string $localPart): void
    {
        $this->localPart = $localPart;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getForwardTo(): string
    {
        return $this->forwardTo;
    }

    /**
     * @param string $forwardTo
     */
    public function setForwardTo(string $forwardTo): void
    {
        $this->forwardTo = $forwardTo;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
