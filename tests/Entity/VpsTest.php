<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\Vps;

class VpsTest extends TestCase
{
    public function testDescriptionChangedAtIsHydratedFromResponse(): void
    {
        $descriptionChangedAt = '2024-01-01 23:59:59';
        $vps = new Vps(['name' => 'example-vps', 'descriptionChangedAt' => $descriptionChangedAt]);

        $this->assertSame($descriptionChangedAt, $vps->getDescriptionChangedAt());
        $this->assertSame($descriptionChangedAt, $vps->jsonSerialize()['descriptionChangedAt']);
    }

    public function testDescriptionChangedAtIsNullWhenMissingFromResponse(): void
    {
        $vps = new Vps(['name' => 'example-vps']);

        $this->assertNull($vps->getDescriptionChangedAt());
        $this->assertArrayHasKey('descriptionChangedAt', $vps->jsonSerialize());
        $this->assertNull($vps->jsonSerialize()['descriptionChangedAt']);
    }
}
