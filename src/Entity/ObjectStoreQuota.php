<?php

namespace Transip\Api\Library\Entity;

class ObjectStoreQuota
{
    /**
     * @description Bytes Quota
     * @example
     * @type number
     * @var int
     */
    protected $bytesQuota;

    /**
     * Used Bytes
     *
     * @var int
     */
    protected $bytesUsed;

    public function getBytesQuota(): int
    {
        return $this->bytesQuota;
    }

    public function getBytesUsed(): int
    {
        return $this->bytesUsed;
    }

    public function setBytesQuota(int $bytesQuota): void
    {
        $this->bytesQuota = $bytesQuota;
    }

    public function setBytesUsed(int $bytesUsed): void
    {
        $this->bytesUsed = $bytesUsed;
    }
}
