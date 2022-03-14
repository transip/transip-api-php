<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\Domain;
use Transip\Api\Library\Entity\Domain\DnsEntry;
use Transip\Api\Library\Entity\Domain\Nameserver;
use Transip\Api\Library\Entity\Domain\WhoisContact;

class EmailRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'email';
}
