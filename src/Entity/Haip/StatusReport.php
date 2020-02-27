<?php

namespace Transip\Api\Library\Entity\Haip;

use Transip\Api\Library\Entity\AbstractEntity;

class StatusReport extends AbstractEntity
{
    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $ipVersion;

    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @var string
     */
    protected $loadBalancerName;

    /**
     * @var string
     */
    protected $loadBalancerIp;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $lastChange;

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
