<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class LicenseKey extends AbstractEntity
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $key;

    public function getName(): string
    {
        return $this->name;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
