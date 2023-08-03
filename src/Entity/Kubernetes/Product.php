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
     * @var ProductPeriodPrice[]
     */
    protected $periodPrices;

    /**
     * @var ProductSpec[]
     */
    protected $specs;

    /**
     * @param mixed[] $valueArray
     */
    public function __construct(array $valueArray)
    {
        $periodPrices = $valueArray['periodPrices'] ?? [];
        $specs = $valueArray['specs'] ?? [];

        foreach ($periodPrices as $periodPrice) {
            $this->periodPrices[] = new ProductPeriodPrice($periodPrice);
        }

        foreach ($specs as $spec) {
            $this->specs[] = new ProductSpec($spec);
        }

        unset($valueArray['periodPrices']);
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

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return ProductPeriodPrice[]
     */
    public function getPeriodPrices(): array
    {
        return $this->periodPrices;
    }

    /**
     * @return ProductSpec[]
     */
    public function getSpecs(): array
    {
        return $this->specs;
    }
}
