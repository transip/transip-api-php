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

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getIpVersion(): string
    {
        return $this->ipVersion;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @return string
     */
    public function getLoadBalancerName(): string
    {
        return $this->loadBalancerName;
    }

    /**
     * @return string
     */
    public function getLoadBalancerIp(): string
    {
        return $this->loadBalancerIp;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getLastChange(): string
    {
        return $this->lastChange;
    }
}