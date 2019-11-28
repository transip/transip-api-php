<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Vps\Snapshot;
use Transip\Api\Client\Repository\ApiRepository;

class SnapshotRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vps', 'snapshots'];
    }

    /**
     * @param string $vpsName
     * @return Snapshot[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $snapshots      = [];
        $response         = $this->httpClient->get($this->getResourceUrl($vpsName));
        $snapshotsArray = $response['snapshots'] ?? [];

        foreach ($snapshotsArray as $snapshotArray) {
            $snapshots[] = new Snapshot($snapshotArray);
        }

        return $snapshots;
    }

    public function getByVpsNameSnapshotName(string $vpsName, string $snapshotName): Snapshot
    {
        $response = $this->httpClient->get($this->getResourceUrl($vpsName, $snapshotName));
        $snapshot = $response['snapshot'] ?? null;
        return new Snapshot($snapshot);
    }

    public function createSnapshot(string $vpsName, string $description): void
    {
        $url = $this->getResourceUrl($vpsName);
        $this->httpClient->post($url, ['description' => $description]);
    }

    public function revertSnapshot(string $vpsName, string $snapshotName, string $destinationVpsName = ''): void
    {
        $url = $this->getResourceUrl($vpsName, $snapshotName);
        $this->httpClient->patch($url, ['destinationVpsName' => $destinationVpsName]);
    }

    public function deleteSnapshot(string $vpsName, string $snapshotName): void
    {
        $url = $this->getResourceUrl($vpsName, $snapshotName) ;
        $this->httpClient->delete($url);
    }
}
