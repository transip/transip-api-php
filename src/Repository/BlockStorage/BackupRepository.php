<?php

namespace Transip\Api\Library\Repository\BlockStorage;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Entity\BlockStorage\Backup;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\BlockStorageRepository;

class BackupRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'backups';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [BlockStorageRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return Backup[]
     */
    public function getByBlockStorageName(string $blockStorageName): array
    {
        $backups      = [];
        $response     = $this->httpClient->get($this->getResourceUrl($blockStorageName));
        $backupsArray = $this->getParameterFromResponse($response, 'backups');

        foreach ($backupsArray as $backupArray) {
            $backups[] = new Backup($backupArray);
        }

        return $backups;
    }

    public function revertBackup(
        string $blockStorageName,
        int $backupId,
        string $destinationBlockStorageName = ''
    ): ResponseInterface {
        return $this->httpClient->patch(
            $this->getResourceUrl($blockStorageName, $backupId),
            [
                'action' => 'revert',
                'destinationBlockStorageName' => $destinationBlockStorageName,
            ]
        );
    }
}
