<?php

namespace Transip\Api\Client\Entity;

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
    public $domainName;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var array $actions
     */
    public $actions;

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
