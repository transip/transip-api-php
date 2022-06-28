<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\SshKey;

class SshKeyRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ssh-keys';

    /**
     * @return SshKey[]
     */
    public function getAll(): array
    {
        $sshKeys      = [];
        $response     = $this->httpClient->get($this->getResourceUrl());
        $sshKeysArray = $this->getParameterFromResponse($response, 'sshKeys');

        foreach ($sshKeysArray as $sshKeyArray) {
            $sshKeys[] = new SshKey($sshKeyArray);
        }

        return $sshKeys;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return SshKey[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $invoices     = [];
        $query        = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response     = $this->httpClient->get($this->getResourceUrl(), $query);
        $sshKeysArray = $this->getParameterFromResponse($response, 'sshKeys');

        $sshKeys = [];
        foreach ($sshKeysArray as $sshKeyArray) {
            $sshKeys[] = new SshKey($sshKeyArray);
        }

        return $sshKeys;
    }

    public function getById(string $sshKeyId): SshKey
    {
        $response    = $this->httpClient->get($this->getResourceUrl($sshKeyId));
        $sshKeyArray = $this->getParameterFromResponse($response, 'sshKey');

        return new SshKey($sshKeyArray);
    }

    public function create(string $sshKey, string $sshKeyDescription, ?bool $isDefault = false): void
    {
        $this->httpClient->post($this->getResourceUrl(), [
            'sshKey'      => $sshKey,
            'description' => $sshKeyDescription,
            'isDefault'   => $isDefault
        ]);
    }

    public function update(int $sshKeyId, string $sshKeyDescription): void
    {
        // fetch current ssh key to preserve the current isDefault value. Needed to preserve backwards compatiblity
        // for the sshkey:setdescription command.
        $sshKey = $this->getById((string) $sshKeyId);
        $sshKey->setDescription($sshKeyDescription);
        $this->updateKey($sshKey);
    }

    public function updateKey(SshKey $sshKey): void
    {
        $this->httpClient->put($this->getResourceUrl($sshKey->getId()), ['sshKey' => $sshKey]);
    }


    public function delete(int $sshKeyId): void
    {
        $this->httpClient->delete($this->getResourceUrl($sshKeyId));
    }
}
