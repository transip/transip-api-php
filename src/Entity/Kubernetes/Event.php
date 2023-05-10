<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class Event extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $reason;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $creationTimestamp;

    /**
     * @var int
     */
    protected $firstTimestamp;

    /**
     * @var int
     */
    protected $lastTimestamp;

    /**
     * @var string
     */
    protected $involvedObjectKind;

    /**
     * @var string
     */
    protected $involvedObjectName;

    /**
     * @var string
     */
    protected $sourceComponent;

    public function getName(): string
    {
        return $this->name;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getCreationTimestamp(): int
    {
        return $this->creationTimestamp;
    }

    public function getFirstTimestamp(): int
    {
        return $this->firstTimestamp;
    }

    public function getLastTimestamp(): int
    {
        return $this->lastTimestamp;
    }

    public function getInvolvedObjectKind(): string
    {
        return $this->involvedObjectKind;
    }

    public function getInvolvedObjectName(): string
    {
        return $this->involvedObjectName;
    }

    public function getSourceComponent(): string
    {
        return $this->sourceComponent;
    }

    public function getInvolvedObject(): string
    {
        return "{$this->getInvolvedObjectKind()}: {$this->getInvolvedObjectName()}";
    }
}
