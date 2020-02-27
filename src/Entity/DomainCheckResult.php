<?php

namespace Transip\Api\Library\Entity;

class DomainCheckResult extends AbstractEntity
{
    public const STATUS_INYOURACCOUNT = 'inyouraccount';
    public const STATUS_UNAVAILABLE = 'unavailable';
    public const STATUS_NOTFREE = 'notfree';
    public const STATUS_FREE = 'free';
    public const STATUS_INTERNALPULL = 'internalpull';
    public const STATUS_INTERNALPUSH = 'internalpush';

    /**
     * @var string $domainName
     */
    protected $domainName;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var array $actions
     */
    protected $actions;

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}
