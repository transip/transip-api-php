<?php

namespace Transip\Api\Client\Entity\Domain;

use Transip\Api\Client\Entity\AbstractEntity;

class Nameserver extends AbstractEntity
{
    /**
     * @var string $hostname
     */
    public $hostname;

    /**
     * @var string $ipv4
     */
    public $ipv4;

    /**
     * @var string $ipv6
     */
    public $ipv6;

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): Nameserver
    {
        $this->hostname = $hostname;
        return $this;
    }

    public function getIpv4(): string
    {
        return $this->ipv4;
    }

    public function setIpv4(string $ipv4): Nameserver
    {
        $this->ipv4 = $ipv4;
        return $this;
    }

    public function getIpv6(): string
    {
        return $this->ipv6;
    }

    public function setIpv6(string $ipv6): Nameserver
    {
        $this->ipv6 = $ipv6;
        return $this;
    }
}
