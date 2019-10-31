<?php

namespace Transip\Api\Client\Repository;

use Transip\Api\Client\Entity\MailServiceInformation;

class MailServiceRepository extends ApiRepository
{
    protected function getRepositoryResourceNames(): array
    {
        return ['mail-service'];
    }

    public function getMailServiceInformation(): ?MailServiceInformation
    {
        $response               = $this->httpClient->get($this->getResourceUrl());
        $mailServiceInformation = $response['mailServiceInformation'] ?? [];

        if ($mailServiceInformation !== null) {
            $mailServiceInformation = new MailServiceInformation($mailServiceInformation);
        }

        return $mailServiceInformation;
    }

    public function regenerateMailServicePassword(): void
    {
        $this->httpClient->patch($this->getResourceUrl(), ['action' => 'reset']);
    }

    public function addMailServiceDnsEntriesToDomains(array $domainNames): void
    {
        $this->httpClient->post($this->getResourceUrl(), ['domains' => $domainNames]);
    }
}
