<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class TCPMonitorContact extends AbstractEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $enableEmail;

    /**
     * @var bool
     */
    protected $enableSMS;

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
     * @return bool
     */
    public function isEnableEmail(): bool
    {
        return $this->enableEmail;
    }

    /**
     * @param bool $enableEmail
     */
    public function setEnableEmail(bool $enableEmail): void
    {
        $this->enableEmail = $enableEmail;
    }

    /**
     * @return bool
     */
    public function isEnableSMS(): bool
    {
        return $this->enableSMS;
    }

    /**
     * @param bool $enableSMS
     */
    public function setEnableSMS(bool $enableSMS): void
    {
        $this->enableSMS = $enableSMS;
    }
}
