<?php

namespace Transip\Api\Library\Entity;

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
    protected $name;

    /**
     * @var int $price
     */
    protected $price;

    /**
     * @var int $recurringPrice
     */
    protected $recurringPrice;

    /**
     * @var array $capabilities
     */
    protected $capabilities;

    /**
     * @var int $minLength
     */
    protected $minLength;

    /**
     * @var int $maxLength
     */
    protected $maxLength;

    /**
     * @var int $registrationPeriodLength
     */
    protected $registrationPeriodLength;

    /**
     * @var int $cancelTimeFrame
     */
    protected $cancelTimeFrame;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getRecurringPrice(): int
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
