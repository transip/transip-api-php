<?php

namespace Transip\Api\Library\Entity;

use Transip\Api\Library\Entity\PrivateNetwork\Vps;

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

    /**
     * @var Vps[] $connectedVpses
     */
    protected $connectedVpses;

    public function __construct(array $valueArray = [])
    {
        $connectedVpses = $valueArray['connectedVpses'] ?? [];
        foreach ($connectedVpses as $connectedVps) {
            $this->connectedVpses[] = new Vps($connectedVps);
        }
        unset($valueArray['connectedVpses']);
        parent::__construct($valueArray);
    }

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

    /**
     * @return string[]
     */
    public function getVpsNames(): array
    {
        return $this->vpsNames;
    }

    /**
     * @return Vps[]
     */
    public function getConnectedVpses(): array
    {
        return $this->connectedVpses;
    }

    public function setDescription(string $description): PrivateNetwork
    {
        $this->description = $description;
        return $this;
    }
}
