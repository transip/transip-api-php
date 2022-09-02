<?php

namespace Transip\Api\Library\Entity\Domain\Tld;

use Transip\Api\Library\Entity\AbstractEntity;

class AdditionalContactField extends AbstractEntity
{
    /** @var string $name */
    public $name;

    /** @var string $type */
    public $type = 'string';

    /** @var bool $isRequired */
    public $isRequired = true;

    /** @var AdditionalContactField[] */
    public $requiredFields = [];

    /** @var array $values  */
    public $values = [];

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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @param bool $isRequired
     */
    public function setIsRequired(bool $isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    /**
     * @return AdditionalContactField[]
     */
    public function getRequiredFields(): array
    {
        return $this->requiredFields;
    }

    /**
     * @param AdditionalContactField[] $requiredFields
     */
    public function setRequiredFields(array $requiredFields): void
    {
        $this->requiredFields = $requiredFields;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    public function fromArray(array $callbackData): self
    {
        $additionalField = new AdditionalContactField();
        $additionalField->setName($callbackData['name'] ?? '');
        $additionalField->setType($callbackData['type'] ?? 'string');
        $additionalField->setValues($callbackData['values'] ?? []);

        $requiredFieldKeys = array_keys($callbackData['requiredFields'] ?? []);
        $requiredFields = [];
        foreach ($requiredFieldKeys as $key) {
            $requiredFields[$key] = array_map([$this, 'fromArray'], $callbackData['requiredFields'][$key] ?? []);
        }

        $additionalField->setRequiredFields($requiredFields);

        return $additionalField;
    }
}
