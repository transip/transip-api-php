<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class TCPMonitorIgnoreTime extends AbstractEntity
{
    /**
     * @var string
     */
    protected $timeFrom;

    /**
     * @var string
     */
    protected $timeTo;

    /**
     * @return string
     */
    public function getTimeFrom(): string
    {
        return $this->timeFrom;
    }

    /**
     * @param string $timeFrom
     */
    public function setTimeFrom(string $timeFrom): void
    {
        $this->timeFrom = $timeFrom;
    }

    /**
     * @return string
     */
    public function getTimeTo(): string
    {
        return $this->timeTo;
    }

    /**
     * @param string $timeTo
     */
    public function setTimeTo(string $timeTo): void
    {
        $this->timeTo = $timeTo;
    }
}
