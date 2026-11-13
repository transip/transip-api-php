<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

/**
 * The domain a domain verification belongs to.
 */
class VerificationDomain extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $registrationStatus;

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegistrationStatus(): string
    {
        return $this->registrationStatus;
    }
}
