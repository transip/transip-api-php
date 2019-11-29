<?php

namespace Transip\Api\Client\Entity\Haip;

use Transip\Api\Client\Entity\AbstractEntity;

class StatusReport extends AbstractEntity
{

    /**
     * @var int
     */
    public $port;
    /**
     * @var string
     */
    public $ipVersion;
    /**
     * @var string
     */
    public $ipAddress;
    /**
     * @var string
     */
    public $loadBalancerName;
    /**
     * @var string
     */
    public $loadBalancerIp;
    /**
     * @var string
     */
    public $state;
    /**
     * @var string
     */
    public $lastChange;

    public function getPort(): int
    {
        return $this->port;
    }

    public function getIpVersion(): string
    {
        return $this->ipVersion;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getLoadBalancerName(): string
    {
        return $this->loadBalancerName;
    }

    public function getLoadBalancerIp(): string
    {
        return $this->loadBalancerIp;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getLastChange(): string
    {
        return $this->lastChange;
    }
}
