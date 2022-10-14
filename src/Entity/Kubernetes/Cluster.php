<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class Cluster extends AbstractEntity
{
    /**
     * identifier of the cluster
     *
     * @var string
     */
    protected $name;

    /**
     * custom cluster description
     *
     * @var string
     */
    protected $description;

    /**
     * kubernetes version the cluster is running
     *
     * @var string
     */
    protected $version;

    /**
     * URL to connect to with kubectl
     *
     * @var string
     */
    protected $endpoint;

    /**
     * When an ongoing process blocks the project from being modified, this is set to `true`
     *
     * @var bool
     */
    protected $isLocked;

    /**
     * Set to `true` when a project has been administratively blocked
     *
     * @var bool
     */
    protected $isBlocked;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
