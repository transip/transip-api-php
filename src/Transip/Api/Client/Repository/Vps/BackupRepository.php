<?php

namespace Transip\Api\Client\Repository\Vps;

use Transip\Api\Client\Entity\Vps\Backup;
use Transip\Api\Client\Repository\ApiRepository;

class BackupRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['vps', 'backups'];
    }

    /**
     * @param string $vpsName
     * @return Backup[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $backups      = [];
        $response     = $this->httpClient->get($this->getResourceUrl($vpsName));
        $backupsArray = $response['backups'] ?? [];

        foreach ($backupsArray as $backupArray) {
            $backups[] = new Backup($backupArray);
        }

        return $backups;
    }

    public function revertBackup(string $vpsName, int $backupId): void
    {
        $this->httpClient->put($this->getResourceUrl($vpsName, $backupId), []);
    }

    public function convertBackupToSnapshot(string $vpsName, int $backupId, string $snapshotDescription = ''): void
    {
        $parameters['description'] = $snapshotDescription;
        $parameters['action']      = 'convert';
        $this->httpClient->patch($this->getResourceUrl($vpsName, $backupId), $parameters);
    }
}
