<?php

namespace Transip\Api\Client\Entity;

class PrivateNetwork extends AbstractEntity
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var bool $isBlocked
     */
    public $isBlocked;

    /**
     * @var bool $isLocked
     */
    public $isLocked;

    /**
     * @var string[] $vpsNames
     */
    public $vpsNames;

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
