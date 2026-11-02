<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\ForwardingService;

class ForwardingServiceRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'forwarding-services';

    /**
     * @return ForwardingService[]
     */
    public function getAll(): array
    {
        $forwardingServices      = [];
        $response                = $this->httpClient->get($this->getResourceUrl());
        $forwardingServicesArray = $this->getParameterFromResponse($response, 'forwardingServices');

        foreach ($forwardingServicesArray as $forwardingServiceArray) {
            $forwardingServices[] = new ForwardingService($forwardingServiceArray);
        }

        return $forwardingServices;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return ForwardingService[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $forwardingServices      = [];
        $query                   = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response                = $this->httpClient->get($this->getResourceUrl(), $query);
        $forwardingServicesArray = $this->getParameterFromResponse($response, 'forwardingServices');

        foreach ($forwardingServicesArray as $forwardingServiceArray) {
            $forwardingServices[] = new ForwardingService($forwardingServiceArray);
        }

        return $forwardingServices;
    }

    public function getByDomainName(string $domainName): ForwardingService
    {
        $response               = $this->httpClient->get($this->getResourceUrl($domainName));
        $forwardingServiceArray = $this->getParameterFromResponse($response, 'forwardingService');

        return new ForwardingService($forwardingServiceArray);
    }

    public function update(ForwardingService $forwardingService): void
    {
        $this->httpClient->put(
            $this->getResourceUrl($forwardingService->getHostname()),
            ['forwardingService' => $forwardingService]
        );
    }
}
