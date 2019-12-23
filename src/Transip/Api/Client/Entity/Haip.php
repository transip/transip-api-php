<?php

namespace Transip\Api\Client\Entity;

class Haip extends AbstractEntity
{
    public const IPSETUP_BOTH = 'both';
    public const IPSETUP_NOIPV6 = 'noipv6';
    public const IPSETUP_IPV6TO4 = 'ipv6to4';
    public const IPSETUP_IPV4TO6 = 'ipv4to6';

    public const BALANCINGMODE_ROUNDROBIN = 'roundrobin';
    public const BALANCINGMODE_COOKIE = 'cookie';
    public const BALANCINGMODE_SOURCE = 'source';

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $status;

    /**
     * @var bool
     */
    public $isLoadBalancingEnabled;

    /**
     * @var string
     */
    public $loadBalancingMode;

    /**
     * @var string
     */
    public $stickyCookieName;

    /**
     * @var string
     */
    public $healthCheckInterval;

    /**
     * @var string
     */
    public $httpHealthCheckPath;

    /**
     * @var string
     */
    public $httpHealthCheckPort;

    /**
     * @var bool
     */
    public $httpHealthCheckSsl;

    /**
     * @var string
     */
    public $ipv4Address;

    /**
     * @var string
     */
    public $ipv6Address;

    /**
     * @var string
     */
    public $ipSetup;

    /**
     * @var string
     */
    public $ptrRecord;

    /**
     * @var string[]
     */
    public $ipAddresses;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isLoadBalancingEnabled(): bool
    {
        return $this->isLoadBalancingEnabled;
    }

    public function getLoadBalancingMode(): string
    {
        return $this->loadBalancingMode;
    }

    public function getStickyCookieName(): string
    {
        return $this->stickyCookieName;
    }

    public function getHealthCheckInterval(): string
    {
        return $this->healthCheckInterval;
    }

    public function getHttpHealthCheckPath(): string
    {
        return $this->httpHealthCheckPath;
    }

    public function getHttpHealthCheckPort(): string
    {
        return $this->httpHealthCheckPort;
    }

    public function getHttpHealthCheckSsl(): string
    {
        return $this->httpHealthCheckSsl;
    }

    public function getIpv4Address(): string
    {
        return $this->ipv4Address;
    }

    public function getIpv6Address(): string
    {
        return $this->ipv6Address;
    }

    public function getIpSetup(): string
    {
        return $this->ipSetup;
    }

    public function getPtrRecord(): string
    {
        return $this->ptrRecord;
    }

    public function getIpAddresses(): array
    {
        return $this->ipAddresses;
    }

    public function setDescription(string $description): Haip
    {
        $this->description = $description;
        return $this;
    }

    public function setLoadBalancingMode(string $loadBalancingMode): Haip
    {
        $this->loadBalancingMode = $loadBalancingMode;
        return $this;
    }

    public function setStickyCookieName(string $stickyCookieName): Haip
    {
        $this->stickyCookieName = $stickyCookieName;
        return $this;
    }

    public function setHealthCheckInterval(string $healthCheckInterval): Haip
    {
        $this->healthCheckInterval = $healthCheckInterval;
        return $this;
    }

    public function setHttpHealthCheckPath(string $httpHealthCheckPath): Haip
    {
        $this->httpHealthCheckPath = $httpHealthCheckPath;
        return $this;
    }

    public function setHttpHealthCheckPort(string $httpHealthCheckPort): Haip
    {
        $this->httpHealthCheckPort = $httpHealthCheckPort;
        return $this;
    }

    public function setHttpHealthCheckSsl(bool $httpHealthCheckSsl): Haip
    {
        $this->httpHealthCheckSsl = $httpHealthCheckSsl;
        return $this;
    }

    public function setIpSetup(string $ipSetup): Haip
    {
        $this->ipSetup = $ipSetup;
        return $this;
    }

    public function setPtrRecord(string $ptrRecord): Haip
    {
        $this->ptrRecord = $ptrRecord;
        return $this;
    }
}
