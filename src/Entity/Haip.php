<?php

namespace Transip\Api\Library\Entity;

class Haip extends AbstractEntity
{
    public const IPSETUP_BOTH = 'both';
    public const IPSETUP_NOIPV6 = 'noipv6';
    public const IPSETUP_IPV6TO4 = 'ipv6to4';
    public const IPSETUP_IPV4TO6 = 'ipv4to6';

    public const BALANCINGMODE_ROUNDROBIN = 'roundrobin';
    public const BALANCINGMODE_COOKIE = 'cookie';
    public const BALANCINGMODE_SOURCE = 'source';

    public const TLSMODE_TLS12 = 'tls12';
    public const TLSMODE_TLS11_12 = 'tls11_12';
    public const TLSMODE_TLS10_11_12 = 'tls10_11_12';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var bool
     */
    protected $isLoadBalancingEnabled;

    /**
     * @var string
     */
    protected $loadBalancingMode;

    /**
     * @var string
     */
    protected $stickyCookieName;

    /**
     * @var string
     */
    protected $healthCheckInterval;

    /**
     * @var string
     */
    protected $httpHealthCheckPath;

    /**
     * @var string
     */
    protected $httpHealthCheckPort;

    /**
     * @var bool
     */
    protected $httpHealthCheckSsl;

    /**
     * @var string
     */
    protected $ipv4Address;

    /**
     * @var string
     */
    protected $ipv6Address;

    /**
     * @var string
     */
    protected $ipSetup;

    /**
     * @var string
     */
    protected $ptrRecord;

    /**
     * @var string[]
     */
    protected $ipAddresses;

    /**
     * @var string
     */
    protected $tlsMode;

    /**
     * @var bool
     */
    protected $isLocked;

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

    public function getTlsMode(): string
    {
        return $this->tlsMode;
    }

    public function setTlsMode(string $tlsMode): void
    {
        $this->tlsMode = $tlsMode;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }
}
