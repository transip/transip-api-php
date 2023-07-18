<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use GuzzleHttp\Promise\AggregateException;
use Transip\Api\Library\Entity\AbstractEntity;
use Transip\Api\Library\Entity\Kubernetes\LoadBalancer\AggregatedStatus;
use Transip\Api\Library\Entity\Kubernetes\LoadBalancer\Balancing;
use Transip\Api\Library\Entity\Kubernetes\LoadBalancer\Port;

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

    /**
     * @var Balancing
     */
    protected $balancing;

    /**
     * @var Port[]
     */
    protected $ports = [];

    /**
     * @var string[]
     */
    protected $nodes = [];

    /**
     * @var AggregatedStatus
     */
    protected $aggregatedStatus;

    /**
     * @var string
     */
    protected $serviceName;
    
    /**
     * @var string
     */
    protected $serviceNamespace;

    public function __construct(array $valueArray = [])
    {
        $this->aggregatedStatus = new AggregatedStatus($valueArray['aggregatedStatus']);
        unset($valueArray['aggregatedStatus']);

        $this->balancing        = new Balancing($valueArray['balancing']);
        unset($valueArray['balancing']);

        foreach ($valueArray['ports'] as $port) {
            $this->ports[] = new Port($port);
        }
        unset($valueArray['ports']);
        parent::__construct($valueArray);
    }

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

    public function getBalancing(): Balancing
    {
        return $this->balancing;
    }

    /**
     * @return Port[]
     */
    public function getPorts(): array
    {
        return $this->ports;
    }

    /**
     * @return string[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function getAggregatedStatus(): AggregatedStatus
    {
        return $this->aggregatedStatus;
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    public function getServiceNamespace(): string
    {
        return $this->serviceNamespace;
    }
}
