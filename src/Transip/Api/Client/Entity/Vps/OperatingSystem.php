<?php

namespace Transip\Api\Client\Entity\Vps;

use Transip\Api\Client\Entity\AbstractEntity;

class OperatingSystem extends AbstractEntity
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
     * @var bool $isPreinstallableImage
     */
    public $isPreinstallableImage;

    /**
     * @var string $version
     */
    public $version;

    /**
     * @var float $price
     */
    public $price;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isPreinstallableImage(): bool
    {
        return $this->isPreinstallableImage;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
