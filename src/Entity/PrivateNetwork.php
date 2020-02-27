<?php

namespace Transip\Api\Library\Entity;

class PrivateNetwork extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var bool $isBlocked
     */
    protected $isBlocked;

    /**
     * @var bool $isLocked
     */
    protected $isLocked;

    /**
     * @var string[] $vpsNames
     */
    protected $vpsNames;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function getVpsNames(): array
    {
        return $this->vpsNames;
    }

    public function setDescription(string $description): PrivateNetwork
    {
        $this->description = $description;
        return $this;
    }
}
