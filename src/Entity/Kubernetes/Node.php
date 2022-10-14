<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class Node extends AbstractEntity
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $nodePoolUuid;

    /**
     * @var string
     */
    protected $clusterName;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var IpAddress[]
     */
    protected $ipAddresses = [];

    /**
     * @param mixed[] $valueArray
     */
    public function __construct(array $valueArray = [])
    {
        $ipAddresses = $valueArray['ipAddresses'] ?? [];
        foreach ($ipAddresses as $ipAddress) {
            $this->ipAddresses[] = new IpAddress($ipAddress);
        }
        unset($valueArray['ipAddresses']);
        parent::__construct($valueArray);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getNodePoolUuid(): string
    {
        return $this->nodePoolUuid;
    }

    public function getClusterName(): string
    {
        return $this->clusterName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return IpAddress[]
     */
    public function getIpAddresses(): array
    {
        return $this->ipAddresses;
    }
}
