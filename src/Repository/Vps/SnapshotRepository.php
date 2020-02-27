<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\Snapshot;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class SnapshotRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'snapshots';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return Snapshot[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $snapshots      = [];
        $response       = $this->httpClient->get($this->getResourceUrl($vpsName));
        $snapshotsArray = $this->getParameterFromResponse($response, 'snapshots');

        foreach ($snapshotsArray as $snapshotArray) {
            $snapshots[] = new Snapshot($snapshotArray);
        }

        return $snapshots;
    }

    public function getByVpsNameSnapshotName(string $vpsName, string $snapshotName): Snapshot
    {
        $response = $this->httpClient->get($this->getResourceUrl($vpsName, $snapshotName));
        $snapshot = $this->getParameterFromResponse($response, 'snapshot');

        return new Snapshot($snapshot);
    }

    public function createSnapshot(string $vpsName, string $description, bool $shouldStartVps = true): void
    {
        $url        = $this->getResourceUrl($vpsName);
        $parameters = [
            'description'    => $description,
            'shouldStartVps' => $shouldStartVps,
        ];
        $this->httpClient->post($url, $parameters);
    }

    public function revertSnapshot(string $vpsName, string $snapshotName, string $destinationVpsName = ''): void
    {
        $url = $this->getResourceUrl($vpsName, $snapshotName);
        $this->httpClient->patch($url, ['destinationVpsName' => $destinationVpsName]);
    }

    public function deleteSnapshot(string $vpsName, string $snapshotName): void
    {
        $url = $this->getResourceUrl($vpsName, $snapshotName);
        $this->httpClient->delete($url);
    }
}
