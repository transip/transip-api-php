<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Haip;

class HaipRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'haips';

    /**
     * @return Haip[]
     */
    public function getAll(): array
    {
        $haips      = [];
        $response   = $this->httpClient->get($this->getResourceUrl());
        $haipsArray = $this->getParameterFromResponse($response, 'haips');

        foreach ($haipsArray as $haipArray) {
            $haips[] = new Haip($haipArray);
        }

        return $haips;
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return Haip[]
     */
    public function getSelection(int $page, int $itemsPerPage): array
    {
        $haips      = [];
        $query      = ['pageSize' => $itemsPerPage, 'page' => $page];
        $response   = $this->httpClient->get($this->getResourceUrl(), $query);
        $haipsArray = $this->getParameterFromResponse($response, 'haips');

        foreach ($haipsArray as $haipArray) {
            $haips[] = new Haip($haipArray);
        }

        return $haips;
    }

    /**
     * @param string $description
     * @return Haip[]
     */
    public function findByDescription(string $description): array
    {
        $haips = [];
        foreach ($this->getAll() as $haip) {
            if ($haip->getDescription() === $description) {
                $haips[] = $haip;
            }
        }

        return $haips;
    }

    public function getByName(string $name): Haip
    {
        $response = $this->httpClient->get($this->getResourceUrl($name));
        $haip     = $this->getParameterFromResponse($response, 'haip');

        return new Haip($haip);
    }

    public function order(
        string $productName,
        ?string $description
    ): void {
        $parameters = ['productName' => $productName];

        if ($description) {
            $parameters['description'] = $description;
        }

        $this->httpClient->post($this->getResourceUrl(), $parameters);
    }

    public function update(Haip $haip): void
    {
        $this->httpClient->put($this->getResourceUrl($haip->getName()), ['haip' => $haip]);
    }

    public function cancel(string $name, string $endTime): void
    {
        $this->httpClient->delete($this->getResourceUrl($name), ['endTime' => $endTime]);
    }
}
