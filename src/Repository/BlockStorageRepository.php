<?php

namespace Transip\Api\Library\Repository;

use Psr\Http\Message\ResponseInterface;
use Transip\Api\Library\Entity\BlockStorage;

class BlockStorageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'block-storages';

    /**
     * @return BlockStorage[]
     */
    public function getAll(): array
    {
        $blockStorages = [];
        $response = $this->httpClient->get($this->getResourceUrl());
        $blockStoragesArray = $this->getParameterFromResponse($response, 'blockStorages');

        foreach ($blockStoragesArray as $blockStorageArray) {
            $blockStorages[] = new BlockStorage($blockStorageArray);
        }

        return $blockStorages;
    }

    /**
     * @return BlockStorage[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $blockStorages = [];
        $query = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response = $this->httpClient->get($this->getResourceUrl(), $query);
        $blockStoragesArray = $this->getParameterFromResponse($response, 'blockStorages');


        foreach ($blockStoragesArray as $blockStorageArray) {
            $blockStorages[] = new BlockStorage($blockStorageArray);
        }

        return $blockStorages;
    }

    public function getByName(string $name): BlockStorage
    {
        $response = $this->httpClient->get($this->getResourceUrl($name));
        $blockStorageArray = $this->getParameterFromResponse($response, 'blockStorage');

        return new BlockStorage($blockStorageArray);
    }

    public function order(
        string $type,
        string $size,
        bool $offsiteBackup = true,
        string $availabilityZone = '',
        string $vpsName = '',
        string $description = ''
    ): ResponseInterface {
        $parameters = [
            'type'             => $type,
            'size'             => $size,
            'offsiteBackups'   => $offsiteBackup,
            'availabilityZone' => $availabilityZone,
            'vpsName'          => $vpsName,
            'description'      => $description,
        ];
        return $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function upgrade(string $blockStorageName, int $size, ?Bool $offsiteBackups = null): void
    {
        $parameters = [
            'blockStorageName' => $blockStorageName,
            'size' => $size
        ];

        if ($offsiteBackups !== null) {
            $parameters['offsiteBackups'] = $offsiteBackups;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(BlockStorage $blockStorage): ResponseInterface
    {
        return $this->httpClient->put(
            $this->getResourceUrl($blockStorage->getName()),
            ['blockStorage' => $blockStorage]
        );
    }

    public function cancel(string $vpsName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName), ['endTime' => $endTime]);
    }
}
