<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class OperatingSystem extends AbstractEntity
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
     * @var bool $isPreinstallableImage
     */
    protected $isPreinstallableImage;

    /**
     * @var string $version
     */
    protected $version;

    /**
     * @var int $price
     */
    protected $price;

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
