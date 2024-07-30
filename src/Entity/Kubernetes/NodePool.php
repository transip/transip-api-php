<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class NodePool extends AbstractEntity
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $clusterName;

    /**
     * @var int
     */
    protected $desiredNodeCount;

    /**
     * @var string
     */
    protected $nodeSpec;

    /**
     * @var string
     */
    protected $availabilityZone;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var Node[]
     */
    protected $nodes = [];

    /**
     * @param mixed[] $valueArray
     */
    public function __construct(array $valueArray = [])
    {
        $nodes = $valueArray['nodes'] ?? [];
        foreach ($nodes as $node) {
            $this->nodes[] = new Node($node);
        }
        unset($valueArray['nodes']);
        parent::__construct($valueArray);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getClusterName(): string
    {
        return $this->clusterName;
    }

    public function getDesiredNodeCount(): int
    {
        return $this->desiredNodeCount;
    }

    public function setDesiredNodeCount(int $desiredNodeCount): void
    {
        $this->desiredNodeCount = $desiredNodeCount;
    }

    public function getNodeSpec(): string
    {
        return $this->nodeSpec;
    }

    public function getAvailabilityZone(): string
    {
        return $this->availabilityZone;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return Node[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }
}
