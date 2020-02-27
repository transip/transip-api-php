<?php

namespace Transip\Api\Library\Entity\Vps;

use Transip\Api\Library\Entity\AbstractEntity;

class TCPMonitor extends AbstractEntity
{
    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $ports;

    /**
     * @var int
     */
    protected $interval;

    /**
     * @var int
     */
    protected $allowedTimeouts;

    /**
     * @var TCPMonitorContact[]
     */
    protected $contacts;

    /**
     * @var TCPMonitorIgnoreTime[]
     */
    protected $ignoreTimes;

    public function __construct(array $valueArray = [])
    {
        parent::__construct($valueArray);

        $contactsArray    = $valueArray['contacts'] ?? [];
        $ignoreTimesArray = $valueArray['ignoreTimes'] ?? [];

        $contacts = [];
        foreach ($contactsArray as $contact) {
            $contacts[] = new TCPMonitorContact($contact);
        }
        $this->contacts = $contacts;

        $ignoreTimes = [];
        foreach ($ignoreTimesArray as $ignoreTime) {
            $ignoreTimes[] = new TCPMonitorIgnoreTime($ignoreTime);
        }
        $this->ignoreTimes = $ignoreTimes;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getPorts(): array
    {
        return $this->ports;
    }

    /**
     * @param array $ports
     */
    public function setPorts(array $ports): void
    {
        $this->ports = $ports;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     */
    public function setInterval(int $interval): void
    {
        $this->interval = $interval;
    }

    /**
     * @return int
     */
    public function getAllowedTimeouts(): int
    {
        return $this->allowedTimeouts;
    }

    /**
     * @param int $allowedTimeouts
     */
    public function setAllowedTimeouts(int $allowedTimeouts): void
    {
        $this->allowedTimeouts = $allowedTimeouts;
    }

    /**
     * @return TCPMonitorContact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * @param TCPMonitorContact[] $contacts
     */
    public function setContacts(array $contacts): void
    {
        $this->contacts = $contacts;
    }

    /**
     * @return TCPMonitorIgnoreTime[]
     */
    public function getIgnoreTimes(): array
    {
        return $this->ignoreTimes;
    }

    /**
     * @param TCPMonitorIgnoreTime[] $ignoreTimes
     */
    public function setIgnoreTimes(array $ignoreTimes): void
    {
        $this->ignoreTimes = $ignoreTimes;
    }
}
