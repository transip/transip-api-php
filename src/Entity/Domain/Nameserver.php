<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

class Nameserver extends AbstractEntity
{
    /**
     * @var string $hostname
     */
    protected $hostname;

    /**
     * @var string $ipv4
     */
    protected $ipv4;

    /**
     * @var string $ipv6
     */
    protected $ipv6;

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
