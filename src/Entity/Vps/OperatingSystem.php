<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

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
     * @var int $price
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

    public function getPrice(): int
    {
        return $this->price;
    }
}
