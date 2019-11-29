<?php

namespace Transip\Api\Client\Entity;

class Colocation extends AbstractEntity
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var array $ipRanges
     */
    public $ipRanges;

    public function getName(): string
    {
        return $this->name;
    }

    public function getIpRanges(): array
    {
        return $this->ipRanges;
    }
}
