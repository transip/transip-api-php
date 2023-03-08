<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\BlockStorage;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class BlockStorageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'block-storages';
    public const RESOURCE_PARAMETER_SINGULAR = 'volume';
    public const RESOURCE_PARAMETER_PLURAL = 'volumes';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @return BlockStorage[]
     */
    public function getAll(string $clusterName): array
    {
        return $this->getBlockStorages($clusterName);
    }

    /**
     * @return BlockStorage[]
     */
    public function getSelection(string $clusterName, int $page, int $itemsPerPage): array
    {
        return $this->getBlockStorages($clusterName, [], $page, $itemsPerPage);
    }

    /**
     * @return BlockStorage[]
     */
    public function getByNodeUuid(string $clusterName, string $nodeUuid, int $page = 0, int $itemsPerPage = 0): array
    {
        return $this->getBlockStorages($clusterName, ['nodeUuid' => $nodeUuid], $page, $itemsPerPage);
    }

    /**
     * @param array<string, mixed> $query
     * @return BlockStorage[]
     */
    private function getBlockStorages(string $clusterName, array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $blockStorages     = [];
        $query['page']     = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl($clusterName), $query);

        $blockStoragesArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($blockStoragesArray as $blockStorageArray) {
            $blockStorages[] = new BlockStorage($blockStorageArray);
        }

        return $blockStorages;
    }

    public function getByName(string $clusterName, string $blockStorageName): BlockStorage
    {
        $response          = $this->httpClient->get($this->getResourceUrl($clusterName, $blockStorageName));
        $blockStorageArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new BlockStorage($blockStorageArray);
    }

    public function add(
        string $name,
        int $sizeInGib,
        string $type,
        string $availabilityZone
    ): void {
        $parameters = [
            'name'             => $name,
            'sizeInGib'        => $sizeInGib,
            'type'             => $type,
            'availabilityZone' => $availabilityZone,
        ];

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(string $clusterName, BlockStorage $blockStorage): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($clusterName, $blockStorage->getName()),
            [self::RESOURCE_PARAMETER_SINGULAR => $blockStorage]
        );
    }

    public function remove(string $clusterName, string $blockStorageName): void
    {
        $this->httpClient->delete($this->getResourceUrl($clusterName, $blockStorageName));
    }
}
