<?php

namespace Transip\Api\Library\Entity;

class AvailabilityZone extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $country
     */
    protected $country;

    /**
     * @var bool $isDefault
     */
    protected $isDefault;

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
