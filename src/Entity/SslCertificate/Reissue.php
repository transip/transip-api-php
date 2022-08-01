<?php

namespace Transip\Api\Library\Entity\SslCertificate;

use Transip\Api\Library\Entity\AbstractEntity;

class Reissue extends AbstractEntity
{
    /**
     * @var string
     */
    public $approverFirstName;

    /**
     * @var string
     */
    public $approverLastName;

    /**
     * @var string
     */
    public $approverEmail;

    /**
     * @var string
     */
    public $approverPhone;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $zipCode;

    /**
     * @var string
     */
    public $countryCode;

    /**
     * @return string
     */
    public function getApproverFirstName()
    {
        return $this->approverFirstName;
    }

    /**
     * @param string $approverFirstName
     */
    public function setApproverFirstName($approverFirstName): void
    {
        $this->approverFirstName = $approverFirstName;
    }

    /**
     * @return string
     */
    public function getApproverLastName()
    {
        return $this->approverLastName;
    }

    /**
     * @param string $approverLastName
     */
    public function setApproverLastName($approverLastName): void
    {
        $this->approverLastName = $approverLastName;
    }

    /**
     * @return string
     */
    public function getApproverEmail()
    {
        return $this->approverEmail;
    }

    /**
     * @param string $approverEmail
     */
    public function setApproverEmail($approverEmail): void
    {
        $this->approverEmail = $approverEmail;
    }

    /**
     * @return string
     */
    public function getApproverPhone()
    {
        return $this->approverPhone;
    }

    /**
     * @param string $approverPhone
     */
    public function setApproverPhone($approverPhone): void
    {
        $this->approverPhone = $approverPhone;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode): void
    {
        $this->countryCode = $countryCode;
    }
}
