<?php

namespace Transip\Api\Library\Entity\Vps;

class UsageDataDisk extends UsageData
{
    /**
     * @var float $iopsRead
     */
    public $iopsRead;

    /**
     * @var float $iopsWrite
     */
    public $iopsWrite;

    public function getIopsRead(): float
    {
        return $this->iopsRead;
    }

    public function getIopsWrite(): float
    {
        return $this->iopsWrite;
    }
}
