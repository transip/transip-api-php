<?php

namespace Transip\Api\Library\Entity;

class OpenStackProject extends AbstractEntity
{
    /**
     * Identifier
     *
     * @var string
     */
    protected $id;

    /**
     * Name of the project
     *
     * @var string
     */
    protected $name;

    /**
     * Describes this project
     *
     * @var string
     */
    protected $description;

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

    /**
     * Indicates whether the project is of type `objectstore` or `openstack`
     *
     * @var string
     */
    protected $type;

    /**
     * The domain in which a project is stored
     *
     * @var string
     */
    protected $domain;

    /**
     * The region in which a project is stored
     *
     * @var string
     */
    protected $region;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getRegion(): string
    {
        return $this->region;
    }
}
