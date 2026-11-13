<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\Domain\Verification;
use Transip\Api\Library\Entity\Domain\VerificationContact;
use Transip\Api\Library\Entity\Domain\VerificationDomain;

class VerificationTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function getVerificationArray(): array
    {
        return [
            'id'                 => 33,
            'domainName'         => 'example.com',
            'status'             => Verification::STATUS_PENDING,
            'createdAt'          => 1786111426,
            'updatedAt'          => 1786111500,
            'responseReceivedAt' => 0,
            'contact'            => [
                'type'        => 'registrant',
                'firstName'   => 'first',
                'middleName'  => 'middle',
                'lastName'    => 'last',
                'companyName' => '',
                'companyKvk'  => '',
                'companyType' => '',
                'street'      => 'street',
                'number'      => '1',
                'postalCode'  => '1234 AB',
                'city'        => 'city',
                'phoneNumber' => '+31 000000000',
                'faxNumber'   => '',
                'email'       => 'firstlast@example.com',
                'country'     => 'nl',
            ],
            'domain'             => [
                'name'               => 'example.com',
                'registrationStatus' => 'registered',
            ],
        ];
    }

    public function testEntityIsHydratedFromApiResponse(): void
    {
        $verification = new Verification($this->getVerificationArray());

        $this->assertSame(33, $verification->getId());
        $this->assertSame('example.com', $verification->getDomainName());
        $this->assertSame(Verification::STATUS_PENDING, $verification->getStatus());
        $this->assertSame(1786111426, $verification->getCreatedAt());
        $this->assertSame(1786111500, $verification->getUpdatedAt());
        $this->assertSame(0, $verification->getResponseReceivedAt());
    }

    public function testNestedObjectsAreHydrated(): void
    {
        $verification = new Verification($this->getVerificationArray());

        $contact = $verification->getContact();
        $this->assertInstanceOf(VerificationContact::class, $contact);
        $this->assertSame('registrant', $contact->getType());
        $this->assertSame('first', $contact->getFirstName());
        $this->assertSame('middle', $contact->getMiddleName());
        $this->assertSame('last', $contact->getLastName());
        $this->assertSame('nl', $contact->getCountry());

        $domain = $verification->getDomain();
        $this->assertInstanceOf(VerificationDomain::class, $domain);
        $this->assertSame('example.com', $domain->getName());
        $this->assertSame('registered', $domain->getRegistrationStatus());
    }

    public function testEmptyContactAndDomainFromListResponse(): void
    {
        // The list response has no contact and domain, empty values are tolerated as well
        $verificationArray = array_merge(
            $this->getVerificationArray(),
            ['contact' => [], 'domain' => []]
        );

        $verification = new Verification($verificationArray);

        $this->assertNull($verification->getContact());
        $this->assertNull($verification->getDomain());
    }

    public function testMissingContactAndDomain(): void
    {
        $verification = new Verification(['id' => 33]);

        $this->assertNull($verification->getContact());
        $this->assertNull($verification->getDomain());
    }
}
