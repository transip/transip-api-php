<?php

namespace Transip\Api\Library\Entity\Vps;

class UsageDataCpu extends UsageData
{
    /**
     * @var float $percentage
     */
    public $percentage;

    public function getPercentage(): float
    {
        return $this->percentage;
    }
}
