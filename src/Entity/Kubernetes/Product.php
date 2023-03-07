<?php

namespace Transip\Api\Library\Entity\Kubernetes;

use Transip\Api\Library\Entity\AbstractEntity;

class Product extends AbstractEntity
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var string
     */
    protected $paymentPeriod;

    /**
     * @var ProductSpec[]
     */
    protected $specs;

    /**
     * @param mixed[] $valueArray
     */
    public function __construct(array $valueArray)
    {
        $specs = $valueArray['specs'] ?? [];
        foreach ($specs as $spec) {
            $this->specs[] = new ProductSpec($spec);
        }

        unset($valueArray['specs']);
        parent::__construct($valueArray);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDesciption(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPaymentPeriod(): string
    {
        return $this->paymentPeriod;
    }

    /**
     * @return ProductSpec[]
     */
    public function getSpecs(): array
    {
        return $this->specs;
    }
}
