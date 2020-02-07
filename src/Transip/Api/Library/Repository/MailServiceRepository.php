<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\MailServiceInformation;

class MailServiceRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'mail-service';

    public function getMailServiceInformation(): MailServiceInformation
    {
        $response               = $this->httpClient->get($this->getResourceUrl());
        $mailServiceInformation = $this->getParameterFromResponse($response, 'mailServiceInformation');

        return new MailServiceInformation($mailServiceInformation);
    }

    public function regenerateMailServicePassword(): void
    {
        $this->httpClient->patch($this->getResourceUrl(), []);
    }

    public function addMailServiceDnsEntriesToDomains(array $domainNames): void
    {
        $this->httpClient->post($this->getResourceUrl(), ['domainNames' => $domainNames]);
    }
}
