<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\ForwardingService;

class ForwardingServiceTest extends TestCase
{
    public function testEntityIsHydratedFromApiResponse(): void
    {
        $forwardingService = new ForwardingService([
            'hostname'          => 'example.com',
            'isBlocked'         => false,
            'isLocked'          => true,
            'forwardTo'         => 'https://www.example.com',
            'forwardMethod'     => ForwardingService::FORWARD_METHOD_IFRAME,
            'frameTitle'        => 'Title',
            'frameIcon'         => 'https://www.example.com/favicon.ico',
            'forwardEverything' => true,
            'forwardSubdomains' => false,
            'sslStatus'         => ForwardingService::SSL_STATUS_ACTIVE,
        ]);

        $this->assertSame('example.com', $forwardingService->getHostname());
        $this->assertFalse($forwardingService->isBlocked());
        $this->assertTrue($forwardingService->isLocked());
        $this->assertSame('https://www.example.com', $forwardingService->getForwardTo());
        $this->assertSame(ForwardingService::FORWARD_METHOD_IFRAME, $forwardingService->getForwardMethod());
        $this->assertTrue($forwardingService->isForwardEverything());
        $this->assertFalse($forwardingService->isForwardSubdomains());
        $this->assertSame(ForwardingService::SSL_STATUS_ACTIVE, $forwardingService->getSslStatus());
    }

    public function testIsLockedIsIncludedWhenTheEntityIsSerialized(): void
    {
        $forwardingService = new ForwardingService(['hostname' => 'example.com', 'isLocked' => true]);

        $serialized = $forwardingService->jsonSerialize();

        $this->assertArrayHasKey('isLocked', $serialized);
        $this->assertTrue($serialized['isLocked']);
    }
}
