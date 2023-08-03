<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class ProductPeriodPrice extends AbstractEntity
{
    /**
     * @var string
     */
    protected $periodUnit;

    /**
     * @var int
     */
    protected $periodLength;

    /**
     * @var bool
     */
    protected $isExact;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var int
     */
    protected $costCents;

    public function getPeriodUnit(): string
    {
        return $this->periodUnit;
    }

    public function getPeriodLength(): int
    {
        return $this->periodLength;
    }

    public function isExact(): bool
    {
        return $this->isExact;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCostCents(): int
    {
        return $this->costCents;
    }
}
