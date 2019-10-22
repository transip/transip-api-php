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
}
