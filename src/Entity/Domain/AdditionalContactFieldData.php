<?php

namespace Transip\Api\Library\Entity\Domain;

class AdditionalContactFieldData
{
    /**
     * @var string $name
     */
    protected $name = '';

    /**
     * @var string $value
     */
    protected $value ='';

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
