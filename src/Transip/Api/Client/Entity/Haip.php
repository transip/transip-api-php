<?php

namespace Transip\Api\Client\Entity;

class Haip extends AbstractEntity
{

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
     * @var string
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isLoadBalancingEnabled(): bool
    {
        return $this->isLoadBalancingEnabled;
    }

    /**
     * @return string
     */
    public function getLoadBalancingMode(): string
    {
        return $this->loadBalancingMode;
    }

    /**
     * @return string
     */
    public function getStickyCookieName(): string
    {
        return $this->stickyCookieName;
    }

    /**
     * @return string
     */
    public function getHealthCheckInterval(): string
    {
        return $this->healthCheckInterval;
    }

    /**
     * @return string
     */
    public function getHttpHealthCheckPath(): string
    {
        return $this->httpHealthCheckPath;
    }

    /**
     * @return string
     */
    public function getHttpHealthCheckPort(): string
    {
        return $this->httpHealthCheckPort;
    }

    /**
     * @return string
     */
    public function getHttpHealthCheckSsl(): string
    {
        return $this->httpHealthCheckSsl;
    }

    /**
     * @return string
     */
    public function getIpv4Address(): string
    {
        return $this->ipv4Address;
    }

    /**
     * @return string
     */
    public function getIpv6Address(): string
    {
        return $this->ipv6Address;
    }

    /**
     * @return string
     */
    public function getIpSetup(): string
    {
        return $this->ipSetup;
    }

    /**
     * @return string
     */
    public function getPtrRecord(): string
    {
        return $this->ptrRecord;
    }

    /**
     * @return string[]
     */
    public function getIpAddresses(): array
    {
        return $this->ipAddresses;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $loadBalancingMode
     */
    public function setLoadBalancingMode(string $loadBalancingMode): void
    {
        $this->loadBalancingMode = $loadBalancingMode;
    }

    /**
     * @param string $stickyCookieName
     */
    public function setStickyCookieName(string $stickyCookieName): void
    {
        $this->stickyCookieName = $stickyCookieName;
    }

    /**
     * @param string $healthCheckInterval
     */
    public function setHealthCheckInterval(string $healthCheckInterval): void
    {
        $this->healthCheckInterval = $healthCheckInterval;
    }

    /**
     * @param string $httpHealthCheckPath
     */
    public function setHttpHealthCheckPath(string $httpHealthCheckPath): void
    {
        $this->httpHealthCheckPath = $httpHealthCheckPath;
    }

    /**
     * @param string $httpHealthCheckPort
     */
    public function setHttpHealthCheckPort(string $httpHealthCheckPort): void
    {
        $this->httpHealthCheckPort = $httpHealthCheckPort;
    }

    /**
     * @param string $httpHealthCheckSsl
     */
    public function setHttpHealthCheckSsl(string $httpHealthCheckSsl): void
    {
        $this->httpHealthCheckSsl = $httpHealthCheckSsl;
    }

    /**
     * @param string $ipSetup
     */
    public function setIpSetup(string $ipSetup): void
    {
        $this->ipSetup = $ipSetup;
    }
}
