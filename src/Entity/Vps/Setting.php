<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class Setting extends AbstractEntity
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $dataType
     */
    public $dataType;

    /**
     * @var bool $readOnly
     */
    public $readOnly;

    /**
     * @var SettingValue $value
     */
    public $value;

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

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType(string $dataType): void
    {
        $this->dataType = $dataType;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly): void
    {
        $this->readOnly = $readOnly;
    }

    /**
     * @return SettingValue
     */
    public function getValue(): SettingValue
    {
        return $this->value;
    }

    /**
     * @param SettingValue $value
     */
    public function setValue(SettingValue $value): void
    {
        $this->value = $value;
    }
}
