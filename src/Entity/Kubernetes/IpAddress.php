<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class IpAddress extends AbstractEntity
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $subnetMask;

    /**
     * @var string
     */
    protected $type;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getSubnetMask(): string
    {
        return $this->subnetMask;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
