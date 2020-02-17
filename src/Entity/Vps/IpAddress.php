<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class IpAddress extends AbstractEntity
{
    /**
     * @var string $address
     */
    public $address;

    /**
     * @var string $subnetMask
     */
    public $subnetMask;

    /**
     * @var string $gateway
     */
    public $gateway;

    /**
     * @var string[] $dnsResolvers
     */
    public $dnsResolvers;

    /**
     * @var string $reverseDns
     */
    public $reverseDns;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getSubnetMask(): string
    {
        return $this->subnetMask;
    }

    public function getGateway(): string
    {
        return $this->gateway;
    }

    /**
     * @return string[]
     */
    public function getDnsResolvers(): array
    {
        return $this->dnsResolvers;
    }

    public function getReverseDns(): string
    {
        return $this->reverseDns;
    }

    public function setReverseDns(string $reverseDns): IpAddress
    {
        $this->reverseDns = $reverseDns;
        return $this;
    }
}
