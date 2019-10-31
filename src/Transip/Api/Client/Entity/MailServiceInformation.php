<?php

namespace Transip\Api\Client\Entity;

class MailServiceInformation extends AbstractEntity
{
    /**
     * @var string $username
     */
    public $username;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var int $usage
     */
    public $usage;

    /**
     * @var int $quota
     */
    public $quota;

    /**
     * @var string $dnsTxt
     */
    public $dnsTxt;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsage(): int
    {
        return $this->usage;
    }

    public function getQuota(): int
    {
        return $this->quota;
    }

    public function getDnsTxt(): string
    {
        return $this->dnsTxt;
    }
}
