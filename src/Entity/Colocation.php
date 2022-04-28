<?php

namespace Transip\Api\Library\Entity;

class Colocation extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string[] $ipRanges
     */
    protected $ipRanges;

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getIpRanges(): array
    {
        return $this->ipRanges;
    }
}
