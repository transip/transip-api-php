<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\HttpClient;

use PHPUnit\Framework\TestCase;
use Http\Client\Common\Plugin;
use Transip\Api\Library\HttpClient\Builder\ClientBuilder;

final class ClientBuilderTest extends TestCase
{
    public function testAddHeaders(): void
    {
        $headers = ['foo', 'bar'];

        $client = $this->getMockBuilder(ClientBuilder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            // TODO verify that headers exists
            ->with($this->isInstanceOf(Plugin\HeaderAppendPlugin::class));

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $client->addHeaders($headers);
    }

    public function testClearHeadersWillRemoveAndAddPlugin(): void
    {
        $builder = $this->getMockBuilder(ClientBuilder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
            ->getMock();
        $builder->expects($this->once())
            ->method('addPlugin')
            ->with($this->isInstanceOf(Plugin\HeaderAppendPlugin::class));

        $builder->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $builder->clearHeaders();
    }

    public function testThatAppendingHeadersShouldRemoveAndAddPlugin(): void
    {
        $expectedHeaders = [
            'Foo' => 'bar',
        ];

        $client = $this->getMockBuilder(ClientBuilder::class)
            ->setMethods(['removePlugin', 'addPlugin'])
            ->getMock();

        $client->expects($this->once())
            ->method('removePlugin')
            ->with(Plugin\HeaderAppendPlugin::class);

        $client->expects($this->once())
            ->method('addPlugin')
            ->with(new Plugin\HeaderAppendPlugin($expectedHeaders));

        $client->addHeaderValue('Foo', 'bar');
    }
}
