<?php

namespace Transip\Api\Client\Entity;

class Tld extends AbstractEntity
{
    public const CAPABILITY_REQUIRESAUTHCODE               = 'requiresAuthCode';
    public const CAPABILITY_CANREGISTER                    = 'canRegister';
    public const CAPABILITY_CANTRANSFERWITHOWNERCHANGE     = 'canTransferWithOwnerChange';
    public const CAPABILITY_CANTRANSFERWITHOUTOWNERCHANGE  = 'canTransferWithoutOwnerChange';
    public const CAPABILITY_CANSETLOCK                     = 'canSetLock';
    public const CAPABILITY_CANSETOWNER                    = 'canSetOwner';
    public const CAPABILITY_CANSETCONTACTS                 = 'canSetContacts';
    public const CAPABILITY_CANSETNAMESERVERS              = 'canSetNameservers';
    public const CAPABILITY_SUPPORTSDNSSEC                 = 'supportsDnsSec';

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var float $price
     */
    public $price;

    /**
     * @var float $recurringPrice
     */
    public $recurringPrice;

    /**
     * @var array $capabilities
     */
    public $capabilities;

    /**
     * @var int $minLength
     */
    public $minLength;

    /**
     * @var int $maxLength
     */
    public $maxLength;

    /**
     * @var int $registrationPeriodLength
     */
    public $registrationPeriodLength;

    /**
     * @var int $cancelTimeFrame
     */
    public $cancelTimeFrame;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getRecurringPrice(): float
    {
        return $this->recurringPrice;
    }

    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    public function getMinLength(): int
    {
        return $this->minLength;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    public function getRegistrationPeriodLength(): int
    {
        return $this->registrationPeriodLength;
    }

    public function getCancelTimeFrame(): int
    {
        return $this->cancelTimeFrame;
    }
}
