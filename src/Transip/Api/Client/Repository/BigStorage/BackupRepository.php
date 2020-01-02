<?php

namespace Transip\Api\Client\Repository\BigStorage;

use Transip\Api\Client\Entity\BigStorage\Backup;
use Transip\Api\Client\Repository\ApiRepository;
use Transip\Api\Client\Repository\BigStorageRepository;

class BackupRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'backups';

    protected function getRepositoryResourceNames(): array
    {
        return [BigStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
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
        $this->httpClient->patch($this->getResourceUrl($bigStorageName, $backupId), ['action' => 'revert']);
    }
}
