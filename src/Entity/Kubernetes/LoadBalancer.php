<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class LoadBalancer extends AbstractEntity
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $ipv4Address;

    /**
     * @var string
     */
    protected $ipv6Address;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getIpv4Address(): string
    {
        return $this->ipv4Address;
    }

    public function getIpv6Address(): string
    {
        return $this->ipv6Address;
    }
}
