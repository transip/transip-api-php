<?php

namespace Transip\Api\Library\Repository\BigStorage;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Entity\BigStorage\Backup;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\BigStorageRepository;

class BackupRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'backups';

    /**
     * @return string[]
     * @deprecated Use block storage resource instead
     */
    protected function getRepositoryResourceNames(): array
    {
        return [BigStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $bigStorageName
     * @return Backup[]
     * @deprecated Use block storage resource instead
     */
    public function getByBigStorageName(string $bigStorageName): array
    {
        $backups      = [];
        $response     = $this->httpClient->get($this->getResourceUrl($bigStorageName));
        $backupsArray = $this->getParameterFromResponse($response, 'backups');

        foreach ($backupsArray as $backupArray) {
            $backups[] = new Backup($backupArray);
        }

        return $backups;
    }

    /**
     * @deprecated Use block storage resource instead
     */
    public function revertBackup(string $bigStorageName, int $backupId, string $destinationBigStorageName = ''): ResponseInterface
    {
        return $this->httpClient->patch(
            $this->getResourceUrl($bigStorageName, $backupId),
            [
                'action' => 'revert',
                'destinationBigStorageName' => $destinationBigStorageName,
            ]
        );
    }
}
