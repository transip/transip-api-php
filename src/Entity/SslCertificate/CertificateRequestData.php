<?php

namespace Transip\Api\Library\Entity\SslCertificate;

use Transip\Api\Library\Entity\AbstractEntity;

/**
 * Entity used to order and reissue SSL certificates
 */
class CertificateRequestData extends AbstractEntity
{
    /**
     * @var string $firstName The first name of the approver
     */
    public $firstName = '';

    /**
     * @var string $lastName The last name of the approver
     */
    public $lastName = '';

    /**
     * @var string $email The email address of the approver
     * @required
     */
    public $email = '';

    /**
     * @var string $phone The phone number of the approver
     */
    public $phone = '';

    /**
     * @var string $address The address
     */
    public $address = '';

    /**
     * @var string $city The city
     */
    public $city = '';

    /**
     * @var string $zipCode The zip code
     */
    public $zipCode = '';

    /**
     * @var string $countryCode The ISO 3166-1 country code
     */
    public $countryCode = '';

    /**
     * @var string $company The company name
     */
    public $company = '';

    /**
     * @var string $department The department name
     */
    public $department = '';

    /**
     * @var string $companyId The company id (kvk)
     */
    public $companyId = '';

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId(string $companyId): void
    {
        $this->companyId = $companyId;
    }

    /**
     * Checks if the required variables have been set
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (trim($this->getEmail()) === '') {
            return false;
        }

        return true;
    }

    /**
     * @return string[]
     */
    public function toArray()
    {
        $dataArr = [
            'approverFirstName' => $this->getFirstName(),
            'approverLastName' => $this->getLastName(),
            'approverEmail' => $this->getEmail(),
            'approverPhone' => $this->getPhone(),
            'company' => $this->getCompany(),
            'department' => $this->getDepartment(),
            'kvk' => $this->getCompanyId(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'zipCode' => $this->getZipCode(),
            'countryCode' => $this->getCountryCode()
        ];

        foreach ($dataArr as $i => $value) {
            if (trim($value) === '') {
                unset($dataArr[$i]);
            }
        }

        return $dataArr;
    }
}
