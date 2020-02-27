<?php

namespace Transip\Api\Library\Entity\Vps;

class UsageDataDisk extends UsageData
{
    /**
     * @var float $iopsRead
     */
    protected $iopsRead;

    /**
     * @var float $iopsWrite
     */
    protected $iopsWrite;

    public function getIopsRead(): float
    {
        return $this->iopsRead;
    }

    public function getIopsWrite(): float
    {
        return $this->iopsWrite;
    }
}
