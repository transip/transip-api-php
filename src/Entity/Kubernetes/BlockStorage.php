<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class BlockStorage extends AbstractEntity
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
     * @var int
     */
    protected $sizeInGib;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $availabilityZone;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $nodeUuid;

    /**
     * @var string
     */
    protected $serial;

    /**
     * @var string
     */
    protected $pvcName;

    /**
     * @var string
     */
    protected $pvcNamespace;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSizeInGib(): int
    {
        return $this->sizeInGib;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAvailabilityZone(): string
    {
        return $this->availabilityZone;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getNodeUuid(): string
    {
        return $this->nodeUuid;
    }

    public function setNodeUuid(string $nodeUuid): void
    {
        $this->nodeUuid = $nodeUuid;
    }

    public function getSerial(): string
    {
        return $this->serial;
    }

    public function getPvcName(): string
    {
        return $this->pvcName;
    }

    public function getPvcNamespace(): string
    {
        return $this->pvcNamespace;
    }
}
