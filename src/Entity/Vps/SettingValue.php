<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class SettingValue extends AbstractEntity
{
    /**
     * @var bool
     */
    public $valueBoolean;

    /**
     * @var string
     */
    public $valueString;

    /**
     * @return bool
     */
    public function getValueBoolean(): bool
    {
        return $this->valueBoolean;
    }

    /**
     * @param bool $valueBoolean
     */
    public function setValueBoolean(bool $valueBoolean): void
    {
        $this->valueBoolean = $valueBoolean;
    }

    /**
     * @return string
     */
    public function getValueString(): string
    {
        return $this->valueString;
    }

    /**
     * @param string $valueString
     */
    public function setValueString(string $valueString): void
    {
        $this->valueString = $valueString;
    }
}
