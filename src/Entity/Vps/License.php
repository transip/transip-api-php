<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class License extends AbstractEntity
{
    public const TYPE_ADDON = 'addon';
    public const TYPE_OPERATING_SYSTEM = 'operating-system';

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var int */
    protected $price;

    /** @var int */
    protected $recurringPrice;

    /** @var string */
    protected $type;

    /** @var int */
    protected $quantity;

    /** @var int */
    protected $maxQuantity;

    /** @var LicenseKey[] */
    protected $keys;

    public function __construct(array $valueArray = [])
    {
        parent::__construct($valueArray);

        $licenseKeysArray = $valueArray['keys'] ?? [];

        $licenseKeys = [];
        foreach ($licenseKeysArray as $licenseKey) {
            $licenseKeys[] = new LicenseKey($licenseKey);
        }
        $this->keys = $licenseKeys;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getRecurringPrice(): int
    {
        return $this->recurringPrice;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getMaxQuantity(): int
    {
        return $this->maxQuantity;
    }

    public function getKeys(): array
    {
        return $this->keys;
    }
}
