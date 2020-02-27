<?php

namespace Transip\Api\Library\Entity;

class Colocation extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var array $ipRanges
     */
    protected $ipRanges;

    public function getName(): string
    {
        return $this->name;
    }

    public function getIpRanges(): array
    {
        return $this->ipRanges;
    }
}
