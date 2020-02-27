<?php

namespace Transip\Api\Library\Entity;

class MailServiceInformation extends AbstractEntity
{
    /**
     * @var string $username
     */
    protected $username;

    /**
     * @var string $password
     */
    protected $password;

    /**
     * @var int $usage
     */
    protected $usage;

    /**
     * @var int $quota
     */
    protected $quota;

    /**
     * @var string $dnsTxt
     */
    protected $dnsTxt;

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
