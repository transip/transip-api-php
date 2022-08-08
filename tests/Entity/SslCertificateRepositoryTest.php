<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\SslCertificate\CertificateRequestData;

class SslCertificateRepositoryTest extends TestCase
{
    public function testToArray()
    {
        $data = new CertificateRequestData();
        $data->setFirstName('John');
        $data->setLastName('Doe');
        $data->setEmail('john.doe@example.com');

        $arr = $data->toArray();

        $this->assertIsArray($arr);
        $this->assertCount(3, $arr);
        $this->assertArrayHasKey('approverFirstName', $arr);
        $this->assertArrayHasKey('approverLastName', $arr);
        $this->assertArrayHasKey('approverEmail', $arr);
    }

    public function testIsValid()
    {
        $data = new CertificateRequestData();
        $data->setEmail('john.doe@example.com');

        $this->assertTrue($data->isValid());
    }

    public function testNotIsValid()
    {
        $data = new CertificateRequestData();

        $this->assertFalse($data->isValid());
    }
}
