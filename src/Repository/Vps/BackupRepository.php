<?php

namespace Transip\Api\Library\Repository\Vps;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Entity\Vps\Backup;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class BackupRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'backups';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return Backup[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $backups      = [];
        $response     = $this->httpClient->get($this->getResourceUrl($vpsName));
        $backupsArray = $this->getParameterFromResponse($response, 'backups');

        foreach ($backupsArray as $backupArray) {
            $backups[] = new Backup($backupArray);
        }

        return $backups;
    }

    public function revertBackup(string $vpsName, int $backupId): ResponseInterface
    {
        return $this->httpClient->patch($this->getResourceUrl($vpsName, $backupId), ['action' => 'revert']);
    }

    public function convertBackupToSnapshot(string $vpsName, int $backupId, string $snapshotDescription = ''): ResponseInterface
    {
        $parameters['description'] = $snapshotDescription;
        $parameters['action']      = 'convert';
        return $this->httpClient->patch($this->getResourceUrl($vpsName, $backupId), $parameters);
    }
}
