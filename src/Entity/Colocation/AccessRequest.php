<?php

namespace Transip\Api\Library\Entity\Colocation;

use Transip\Api\Library\Entity\AbstractEntity;

class AccessRequest extends AbstractEntity
{
    /**
     * @var string $coloName
     */
    protected $coloName;

    /**
     * The datetime of the wanted datacenter access, in YYYY-MM-DD hh:mm:ss format
     * @var string $dateTime
     */
    protected $dateTime;

    /**
     * The expected duration of the visit, in minutes
     * @var int $duration
     */
    protected $duration;

    /**
     * List of visitor names for this datacenter visit, must be at least 1 and at most 20
     * @var string[] $visitorNames
     */
    protected $visitorNames;

    /**
     * If an SMS with access codes needs to be sent, set the phone number of the receiving phone here
     * @var string $phoneNumber
     */
    protected $phoneNumber;

    public function getColoName(): string
    {
        return $this->coloName;
    }

    public function setColoName(string $coloName): void
    {
        $this->coloName = $coloName;
    }

    public function getDateTime(): string
    {
        return $this->dateTime;
    }

    public function setDateTime(string $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return string[]
     */
    public function getVisitorNames(): array
    {
        return $this->visitorNames;
    }

    /**
     * @param string[] $visitorNames
     */
    public function setVisitorNames(array $visitorNames): void
    {
        $this->visitorNames = $visitorNames;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
}
