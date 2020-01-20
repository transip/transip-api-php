<?php

namespace Transip\Api\Library\Entity;

class TrafficInformation extends AbstractEntity
{
    /**
     * @var string $startDate
     */
    public $startDate;

    /**
     * @var string $endDate
     */
    public $endDate;

    /**
     * @var int $usedInBytes
     */
    public $usedInBytes;

    /**
     * @var int $usedTotalBytes
     */
    public $usedTotalBytes;

    /**
     * @var int $maxInBytes
     */
    public $maxInBytes;

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function getUsedInBytes(): int
    {
        return $this->usedInBytes;
    }

    public function getUsedOutBytes(): int
    {
        return $this->getUsedTotalBytes() - $this->getUsedInBytes();
    }

    public function getUsedTotalBytes(): int
    {
        return $this->usedTotalBytes;
    }

    public function getMaxInBytes(): int
    {
        return $this->maxInBytes;
    }

    public function getUsedInMegabytes(): float
    {
        return round($this->getUsedInBytes() / 1024, 2);
    }

    public function getUsedOutMegabytes(): int
    {
        $usedInMegabytes    = $this->getUsedInBytes() / 1024;
        $usedTotalMegabytes = $this->getUsedTotalBytes() / 1024;

        return round($usedTotalMegabytes - $usedInMegabytes, 2);
    }

    public function getUsedTotalMegabytes(): float
    {
        return round($this->getUsedTotalBytes() / 1024, 2);
    }

    public function getMaxInMegabytes(): float
    {
        return round($this->getMaxInBytes() / 1024, 2);
    }

    public function getUsedInGigabytes(): float
    {
        return round($this->getUsedInBytes() / 1024 / 1024, 2);
    }

    public function getUsedOutGigabytes(): int
    {
        $usedInGigabytes    = $this->getUsedInBytes() / 1024 / 1024;
        $usedTotalGigabytes = $this->getUsedTotalBytes() / 1024 / 1024;

        return round($usedTotalGigabytes - $usedInGigabytes, 2);
    }

    public function getUsedTotalGigabytes(): float
    {
        return round($this->getUsedTotalBytes() / 1024 / 1024, 2);
    }

    public function getMaxInGigabytes(): float
    {
        return round($this->getMaxInBytes() / 1024 / 1024, 2);
    }
}
