<?php

namespace Transip\Api\Library\Entity;

class OpenStackProject extends AbstractEntity
{
    /**
     * @description Identifier
     * @example `7a7a3bcb46c6450f95c53edb8dcebc7b`
     * @type string
     * @readonly
     */
    protected $id;

    /**
     * @description Name of the project
     * @example `hosting101-datacenter`
     * @type string
     */
    protected $name;

    /**
     * @description Describes this project
     * @example This is an example project
     * @type string
     */
    protected $description;

    /**
     * @description When an ongoing process blocks the project from being modified, this is set to `true`
     * @example false
     * @type boolean
     * @readonly
     */
    protected $isLocked;

    /**
     * @description Set to `true` when a project has been administratively blocked
     * @example false
     * @type boolean
     * @readonly
     */
    protected $isBlocked;

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

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
