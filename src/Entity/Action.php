<?php

namespace Transip\Api\Library\Entity;

class Action extends AbstractEntity
{
    public const STATUS_RUNNING = 'running';
    public const STATUS_FINISHED = 'finished';

    /**
     * @var string $uuid
     */
    protected $uuid;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $actionStartTime
     */
    protected $actionStartTime;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $resourceType
     */
    protected $resourceType;

    /**
     * @var string $resourceIdentifier
     */
    protected $resourceIdentifier;

    /**
     * @var array<mixed> $metadata
     */
    protected $metadata;

    /**
     * Get $uuid
     *
     * @return  string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get $name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get $actionStartTime
     *
     * @return  string
     */
    public function getActionStartTime()
    {
        return $this->actionStartTime;
    }

    /**
     * Get $status
     *
     * @return  string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get $resourceType
     *
     * @return  string
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * Get $resourceIdentifier
     *
     * @return  string
     */
    public function getResourceIdentifier()
    {
        return $this->resourceIdentifier;
    }

    /**
     * Get $metadata
     *
     * @return array<mixed>
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
