<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\BigStorage;

class BigStorageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'big-storages';

    /**
     * @return BigStorage[]
     */
    public function getAll(): array
    {
        $bigStorages      = [];
        $response         = $this->httpClient->get($this->getResourceUrl());
        $bigStoragesArray = $this->getParameterFromResponse($response, 'bigStorages');

        foreach ($bigStoragesArray as $bigstorageArray) {
            $bigStorages[] = new BigStorage($bigstorageArray);
        }

        return $bigStorages;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return BigStorage[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $bigStorages      = [];
        $query            = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response         = $this->httpClient->get($this->getResourceUrl(), $query);
        $bigStoragesArray = $this->getParameterFromResponse($response, 'bigStorages');


        foreach ($bigStoragesArray as $bigstorageArray) {
            $bigStorages[] = new BigStorage($bigstorageArray);
        }

        return $bigStorages;
    }

    public function getByName(string $privateNetworkName): BigStorage
    {
        $response        = $this->httpClient->get($this->getResourceUrl($privateNetworkName));
        $bigStorageArray = $this->getParameterFromResponse($response, 'bigStorage');

        return new BigStorage($bigStorageArray);
    }

    public function order(
        string $size,
        bool $offsiteBackup = true,
        string $availabilityZone = '',
        string $vpsName = '',
        string $description = ''
    ): void {
        $parameters = [
            'size'             => $size,
            'offsiteBackups'   => $offsiteBackup,
            'availabilityZone' => $availabilityZone,
            'vpsName'          => $vpsName,
            'description'      => $description,
        ];
        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function upgrade(string $bigStorageName, int $size, ?Bool $offsiteBackups = null)
    {
        $parameters = [
            'bigStorageName'   => $bigStorageName,
            'size'             => $size
        ];

        if ($offsiteBackups !== null) {
            $parameters['offsiteBackups'] = $offsiteBackups;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(BigStorage $bigStorage): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($bigStorage->getName()),
            ['bigStorage' => $bigStorage]
        );
    }

    public function cancel(string $vpsName, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName), ['endTime' => $endTime]);
    }
}
