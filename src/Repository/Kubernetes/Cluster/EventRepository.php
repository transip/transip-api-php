<?php

namespace Transip\Api\Library\Repository\Kubernetes\Cluster;

use Transip\Api\Library\Entity\Kubernetes\Event;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\Kubernetes\ClusterRepository;

class EventRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'events';
    public const RESOURCE_PARAMETER_SINGULAR = 'event';
    public const RESOURCE_PARAMETER_PLURAL = 'events';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [ClusterRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $clusterName
     * @return Event[]
     */
    public function getAll(string $clusterName): array
    {
        return $this->getEvents($clusterName);
    }

    /**
     * @param string $clusterName
     * @param string $namespace
     * @return Event[]
     */
    public function getByNamespace(string $clusterName, string $namespace): array
    {
        return $this->getEvents($clusterName, ['namespace' => $namespace]);
    }

    /**
     * @param string $clusterName
     * @param string $namespace
     * @param string $eventName
     * @return Event
     */
    public function getByNamespaceAndName(string $clusterName, string $namespace, string $eventName): Event
    {
        $response = $this->httpClient->get($this->getResourceUrl($clusterName, $eventName), ['namespace' => $namespace]);
        $eventArray = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_SINGULAR);
        return new Event($eventArray);
    }

    /**
     * @param string $clusterName
     * @param array<string, mixed> $query
     * @return Event[]
     */
    private function getEvents(string $clusterName, array $query = []): array
    {
        $response      = $this->httpClient->get($this->getResourceUrl($clusterName), $query);
        $eventsArray   = $this->getParameterFromResponse($response, self::RESOURCE_PARAMETER_PLURAL);
        return array_map(static fn ($eventArray) => new Event($eventArray), $eventsArray);
    }
}
