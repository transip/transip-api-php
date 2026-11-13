<?php

declare(strict_types=1);

namespace Transip\Api\Library\Tests\Repository;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Transip\Api\Library\Entity\Domain\Verification;
use Transip\Api\Library\Exception\ApiClientException;
use Transip\Api\Library\HttpClient\HttpClientInterface;
use Transip\Api\Library\Repository\DomainVerificationRepository;

class DomainVerificationRepositoryTest extends TestCase
{
    /**
     * @var HttpClientInterface&MockObject
     */
    private $httpClient;

    /**
     * @var DomainVerificationRepository
     */
    private $repository;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->repository = new DomainVerificationRepository($this->httpClient);
    }

    /**
     * @return array<string, mixed>
     */
    private function getVerificationArray(int $id): array
    {
        return [
            'id'         => $id,
            'domainName' => 'example.com',
            'status'     => Verification::STATUS_PENDING,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getVerificationArrays(int $amount, int $firstId = 1): array
    {
        $verifications = [];
        for ($id = $firstId; $id < $firstId + $amount; $id++) {
            $verifications[] = $this->getVerificationArray($id);
        }

        return $verifications;
    }

    public function testGetSelectionWithoutFilters(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with('/domain-verifications', ['pageSize' => 10, 'page' => 2])
            ->willReturn(['verifications' => $this->getVerificationArrays(2)]);

        $verifications = $this->repository->getSelection(2, 10);

        $this->assertCount(2, $verifications);
        $this->assertContainsOnlyInstancesOf(Verification::class, $verifications);
        $this->assertSame(1, $verifications[0]->getId());
    }

    public function testGetSelectionLeavesOutContactAndDomain(): void
    {
        $withContactAndDomain = array_merge(
            $this->getVerificationArray(1),
            [
                'contact' => ['type' => 'registrant', 'firstName' => 'first'],
                'domain'  => ['name' => 'example.com'],
            ]
        );

        $this->httpClient->expects($this->once())
            ->method('get')
            ->willReturn(['verifications' => [$withContactAndDomain]]);

        $verifications = $this->repository->getSelection(1, 25);

        $this->assertNull($verifications[0]->getContact());
        $this->assertNull($verifications[0]->getDomain());
    }

    public function testGetSelectionJoinsStatusesWithAComma(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with(
                '/domain-verifications',
                [
                    'pageSize'   => 25,
                    'page'       => 1,
                    'domainName' => 'example.com',
                    'statuses'   => 'pending,failed',
                ]
            )
            ->willReturn(['verifications' => []]);

        $verifications = $this->repository->getSelection(
            1,
            25,
            'example.com',
            [Verification::STATUS_PENDING, Verification::STATUS_FAILED]
        );

        $this->assertSame([], $verifications);
    }

    public function testGetSelectionIgnoresEmptyFilters(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with('/domain-verifications', ['pageSize' => 25, 'page' => 1])
            ->willReturn(['verifications' => []]);

        $this->repository->getSelection(1, 25, '', []);
    }

    public function testGetSelectionThrowsWhenVerificationsAreMissingInTheResponse(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->willReturn([]);

        $this->expectException(ApiClientException::class);

        $this->repository->getSelection(1, 25);
    }

    public function testGetAllFetchesAllPages(): void
    {
        $this->httpClient->expects($this->exactly(3))
            ->method('get')
            ->withConsecutive(
                ['/domain-verifications', ['pageSize' => 100, 'page' => 1, 'domainName' => 'example.com']],
                ['/domain-verifications', ['pageSize' => 100, 'page' => 2, 'domainName' => 'example.com']],
                ['/domain-verifications', ['pageSize' => 100, 'page' => 3, 'domainName' => 'example.com']]
            )
            ->willReturnOnConsecutiveCalls(
                ['verifications' => $this->getVerificationArrays(100)],
                ['verifications' => $this->getVerificationArrays(100, 101)],
                ['verifications' => $this->getVerificationArrays(5, 201)]
            );

        $verifications = $this->repository->getAll('example.com');

        $this->assertCount(205, $verifications);
        $this->assertSame(205, $verifications[204]->getId());
    }

    public function testGetAllStopsWhenTheFirstPageIsNotFull(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with('/domain-verifications', ['pageSize' => 100, 'page' => 1, 'statuses' => 'success'])
            ->willReturn(['verifications' => $this->getVerificationArrays(3)]);

        $verifications = $this->repository->getAll(null, [Verification::STATUS_SUCCESS]);

        $this->assertCount(3, $verifications);
    }

    public function testGetById(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with('/domain-verifications/33')
            ->willReturn(['verification' => $this->getVerificationArray(33)]);

        $verification = $this->repository->getById(33);

        $this->assertSame(33, $verification->getId());
        $this->assertSame('example.com', $verification->getDomainName());
    }

    public function testGetByIdThrowsWhenVerificationIsMissingInTheResponse(): void
    {
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with('/domain-verifications/33')
            ->willReturn([]);

        $this->expectException(ApiClientException::class);

        $this->repository->getById(33);
    }
}
