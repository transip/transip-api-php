<?php

namespace Transip\Api\Library\Repository\Kubernetes;

use Transip\Api\Library\Entity\Kubernetes\BlockStorage;
use Transip\Api\Library\Repository\ApiRepository;

class BlockStorageRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'kubernetes/block-storages';
    public const RESOURCE_PARAMETER_SINGULAR = 'volume';
    public const RESOURCE_PARAMETER_PLURAL = 'volumes';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [self::RESOURCE_NAME];
    }

    /**
     * @return BlockStorage[]
     */
    public function getAll(): array
    {
        return $this->getBlockStorages();
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return BlockStorage[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        return $this->getBlockStorages([], $page, $itemsPerPage);
    }

    /**
     * @param string $nodeUuid
     * @return BlockStorage[]
     */
    public function getByNodeUuid(string $nodeUuid, int $page = 0, int $itemsPerPage = 0): array
    {
        return $this->getBlockStorages(['nodeUuid' => $nodeUuid], $page, $itemsPerPage);
    }

    /**
     * @param mixed[] $query
     * @return BlockStorage[]
     */
    private function getBlockStorages(array $query = [], int $page = 0, int $itemsPerPage = 0): array
    {
        $blockStorages     = [];
        $query['page']     = $page;
        $query['pageSize'] = $itemsPerPage;

        $response = $this->httpClient->get($this->getResourceUrl(), $query);

        $blockStoragesArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);

        foreach ($blockStoragesArray as $blockStorageArray) {
            $blockStorages[] = new BlockStorage($blockStorageArray);
        }

        return $blockStorages;
    }

    public function getByName(string $blockStorageName): BlockStorage
    {
        $response          = $this->httpClient->get($this->getResourceUrl($blockStorageName));
        $blockStorageArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);

        return new BlockStorage($blockStorageArray);
    }

    public function add(
        string $name,
        int $sizeInGib,
        string $type,
        string $availabilityZone
    ): void {
        $parameters['name']             = $name;
        $parameters['sizeInGib']        = $sizeInGib;
        $parameters['type']             = $type;
        $parameters['availabilityZone'] = $availabilityZone;

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(BlockStorage $blockStorage): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($blockStorage->getName()),
            [self::RESOURCE_PARAMETER_SINGULAR => $blockStorage]
        );
    }

    public function remove(string $blockStorageName): void
    {
        $this->httpClient->delete($this->getResourceUrl($blockStorageName));
    }
}
