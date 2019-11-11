<?php

namespace Transip\Api\Client\Repository\BigStorage;

use Transip\Api\Client\Entity\BigStorage\Backup;
use Transip\Api\Client\Repository\ApiRepository;

class BackupRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['big-storages', 'backups'];
    }

    /**
     * @param string $bigStorageName
     * @return Backup[]
     */
    public function getByBigStorageName(string $bigStorageName): array
    {
        $backups      = [];
        $response     = $this->httpClient->get($this->getResourceUrl($bigStorageName));
        $backupsArray = $response['backups'] ?? [];

        foreach ($backupsArray as $backupArray) {
            $backups[] = new Backup($backupArray);
        }

        return $backups;
    }

    public function revertBackup(string $bigStorageName, int $backupId): void
    {
        $parameters['action'] = 'revert';
        $parameters['backupId'] = $backupId;
        $this->httpClient->patch($this->getResourceUrl($bigStorageName), $parameters);
    }
}
