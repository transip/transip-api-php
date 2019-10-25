<?php

namespace Transip\Api\Client\Entity;

class AvailabilityZone extends AbstractEntity
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $country
     */
    public $country;

    /**
     * @var bool $isDefault
     */
    public $isDefault;

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }
}
