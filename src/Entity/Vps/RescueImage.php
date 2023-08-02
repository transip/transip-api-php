<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class RescueImage extends AbstractEntity
{
    /**
     * @var string
     */

    public $name;

    /**
     * True when the rescue image supports booting with provided ssh-keys
     * @var bool
     */
    public $supportsSshKeys;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSupportsSshKeys(): bool
    {
        return $this->supportsSshKeys;
    }
}
