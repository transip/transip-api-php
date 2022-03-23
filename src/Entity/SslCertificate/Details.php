<?php

namespace Transip\Api\Library\Entity\SslCertificate;

use Transip\Api\Library\Entity\AbstractEntity;

class Details extends AbstractEntity
{
    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $department;

    /**
     * @var string
     */
    public $postbox;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $zipcode;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $countryCode;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $expirationDate;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var int
     */
    public $version;

    /**
     * @var string
     */
    public $serialNumber;

    /**
     * @var string
     */
    public $serialNumberHex;

    /**
     * @var string
     */
    public $validFrom;

    /**
     * @var string
     */
    public $validTo;

    /**
     * @var int
     */
    public $validFromTimestamp;

    /**
     * @var int
     */
    public $validToTimestamp;

    /**
     * @var string
     */
    public $signatureTypeSN;

    /**
     * @var string
     */
    public $signatureTypeLN;

    /**
     * @var int
     */
    public $signatureTypeNID;

    /**
     * @var string
     */
    public $subjectCommonName;

    /**
     * @var string
     */
    public $issuerCountry;

    /**
     * @var string
     */
    public $issuerOrganization;

    /**
     * @var string
     */
    public $issuerCommonName;

    /**
     * @var string
     */
    public $keyUsage;

    /**
     * @var string
     */
    public $basicConstraints;

    /**
     * @var string
     */
    public $enhancedKeyUsage;

    /**
     * @var string
     */
    public $subjectKeyIdentifier;

    /**
     * @var string
     */
    public $authorityKeyIdentifier;

    /**
     * @var string
     */
    public $authorityInformationAccess;

    /**
     * @var string
     */
    public $subjectAlternativeName;

    /**
     * @var string
     */
    public $certificatePolicies;

    /**
     * @var string
     */
    public $signedCertificateTimestamp;

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
    public function getPostbox(): string
    {
        return $this->postbox;
    }

    /**
     * @param string $postbox
     */
    public function setPostbox(string $postbox): void
    {
        $this->postbox = $postbox;
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
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
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
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
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
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    /**
     * @param string $expirationDate
     */
    public function setExpirationDate(string $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     */
    public function setSerialNumber(string $serialNumber): void
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @return string
     */
    public function getSerialNumberHex(): string
    {
        return $this->serialNumberHex;
    }

    /**
     * @param string $serialNumberHex
     */
    public function setSerialNumberHex(string $serialNumberHex): void
    {
        $this->serialNumberHex = $serialNumberHex;
    }

    /**
     * @return string
     */
    public function getValidFrom(): string
    {
        return $this->validFrom;
    }

    /**
     * @param string $validFrom
     */
    public function setValidFrom(string $validFrom): void
    {
        $this->validFrom = $validFrom;
    }

    /**
     * @return string
     */
    public function getValidTo(): string
    {
        return $this->validTo;
    }

    /**
     * @param string $validTo
     */
    public function setValidTo(string $validTo): void
    {
        $this->validTo = $validTo;
    }

    /**
     * @return int
     */
    public function getValidFromTimestamp(): int
    {
        return $this->validFromTimestamp;
    }

    /**
     * @param int $validFromTimestamp
     */
    public function setValidFromTimestamp(int $validFromTimestamp): void
    {
        $this->validFromTimestamp = $validFromTimestamp;
    }

    /**
     * @return int
     */
    public function getValidToTimestamp(): int
    {
        return $this->validToTimestamp;
    }

    /**
     * @param int $validToTimestamp
     */
    public function setValidToTimestamp(int $validToTimestamp): void
    {
        $this->validToTimestamp = $validToTimestamp;
    }

    /**
     * @return string
     */
    public function getSignatureTypeSN(): string
    {
        return $this->signatureTypeSN;
    }

    /**
     * @param string $signatureTypeSN
     */
    public function setSignatureTypeSN(string $signatureTypeSN): void
    {
        $this->signatureTypeSN = $signatureTypeSN;
    }

    /**
     * @return string
     */
    public function getSignatureTypeLN(): string
    {
        return $this->signatureTypeLN;
    }

    /**
     * @param string $signatureTypeLN
     */
    public function setSignatureTypeLN(string $signatureTypeLN): void
    {
        $this->signatureTypeLN = $signatureTypeLN;
    }

    /**
     * @return int
     */
    public function getSignatureTypeNID(): int
    {
        return $this->signatureTypeNID;
    }

    /**
     * @param int $signatureTypeNID
     */
    public function setSignatureTypeNID(int $signatureTypeNID): void
    {
        $this->signatureTypeNID = $signatureTypeNID;
    }

    /**
     * @return string
     */
    public function getSubjectCommonName(): string
    {
        return $this->subjectCommonName;
    }

    /**
     * @param string $subjectCommonName
     */
    public function setSubjectCommonName(string $subjectCommonName): void
    {
        $this->subjectCommonName = $subjectCommonName;
    }

    /**
     * @return string
     */
    public function getIssuerCountry(): string
    {
        return $this->issuerCountry;
    }

    /**
     * @param string $issuerCountry
     */
    public function setIssuerCountry(string $issuerCountry): void
    {
        $this->issuerCountry = $issuerCountry;
    }

    /**
     * @return string
     */
    public function getIssuerOrganization(): string
    {
        return $this->issuerOrganization;
    }

    /**
     * @param string $issuerOrganization
     */
    public function setIssuerOrganization(string $issuerOrganization): void
    {
        $this->issuerOrganization = $issuerOrganization;
    }

    /**
     * @return string
     */
    public function getIssuerCommonName(): string
    {
        return $this->issuerCommonName;
    }

    /**
     * @param string $issuerCommonName
     */
    public function setIssuerCommonName(string $issuerCommonName): void
    {
        $this->issuerCommonName = $issuerCommonName;
    }

    /**
     * @return string
     */
    public function getKeyUsage(): string
    {
        return $this->keyUsage;
    }

    /**
     * @param string $keyUsage
     */
    public function setKeyUsage(string $keyUsage): void
    {
        $this->keyUsage = $keyUsage;
    }

    /**
     * @return string
     */
    public function getBasicConstraints(): string
    {
        return $this->basicConstraints;
    }

    /**
     * @param string $basicConstraints
     */
    public function setBasicConstraints(string $basicConstraints): void
    {
        $this->basicConstraints = $basicConstraints;
    }

    /**
     * @return string
     */
    public function getEnhancedKeyUsage(): string
    {
        return $this->enhancedKeyUsage;
    }

    /**
     * @param string $enhancedKeyUsage
     */
    public function setEnhancedKeyUsage(string $enhancedKeyUsage): void
    {
        $this->enhancedKeyUsage = $enhancedKeyUsage;
    }

    /**
     * @return string
     */
    public function getSubjectKeyIdentifier(): string
    {
        return $this->subjectKeyIdentifier;
    }

    /**
     * @param string $subjectKeyIdentifier
     */
    public function setSubjectKeyIdentifier(string $subjectKeyIdentifier): void
    {
        $this->subjectKeyIdentifier = $subjectKeyIdentifier;
    }

    /**
     * @return string
     */
    public function getAuthorityKeyIdentifier(): string
    {
        return $this->authorityKeyIdentifier;
    }

    /**
     * @param string $authorityKeyIdentifier
     */
    public function setAuthorityKeyIdentifier(string $authorityKeyIdentifier): void
    {
        $this->authorityKeyIdentifier = $authorityKeyIdentifier;
    }

    /**
     * @return string
     */
    public function getAuthorityInformationAccess(): string
    {
        return $this->authorityInformationAccess;
    }

    /**
     * @param string $authorityInformationAccess
     */
    public function setAuthorityInformationAccess(string $authorityInformationAccess): void
    {
        $this->authorityInformationAccess = $authorityInformationAccess;
    }

    /**
     * @return string
     */
    public function getSubjectAlternativeName(): string
    {
        return $this->subjectAlternativeName;
    }

    /**
     * @param string $subjectAlternativeName
     */
    public function setSubjectAlternativeName(string $subjectAlternativeName): void
    {
        $this->subjectAlternativeName = $subjectAlternativeName;
    }

    /**
     * @return string
     */
    public function getCertificatePolicies(): string
    {
        return $this->certificatePolicies;
    }

    /**
     * @param string $certificatePolicies
     */
    public function setCertificatePolicies(string $certificatePolicies): void
    {
        $this->certificatePolicies = $certificatePolicies;
    }

    /**
     * @return string
     */
    public function getSignedCertificateTimestamp(): string
    {
        return $this->signedCertificateTimestamp;
    }

    /**
     * @param string $signedCertificateTimestamp
     */
    public function setSignedCertificateTimestamp(string $signedCertificateTimestamp): void
    {
        $this->signedCertificateTimestamp = $signedCertificateTimestamp;
    }
}
