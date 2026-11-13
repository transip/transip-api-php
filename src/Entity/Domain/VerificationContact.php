<?php

namespace Transip\Api\Library\Entity\Domain;

use Transip\Api\Library\Entity\AbstractEntity;

/**
 * The contact that was submitted for a domain verification.
 *
 * This is read only and separate from WhoisContact, because it contains a middle name and WhoisContact is also used
 * to send contacts to the API.
 */
class VerificationContact extends AbstractEntity
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $middleName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $companyKvk;

    /**
     * @var string
     */
    protected $companyType;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $postalCode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $faxNumber;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $country;

    public function getType(): string
    {
        return $this->type;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getCompanyKvk(): string
    {
        return $this->companyKvk;
    }

    public function getCompanyType(): string
    {
        return $this->companyType;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getFaxNumber(): string
    {
        return $this->faxNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
