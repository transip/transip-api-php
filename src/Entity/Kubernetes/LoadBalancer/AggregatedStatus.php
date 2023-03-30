<?php
namespace Transip\Api\Library\Entity\Kubernetes\LoadBalancer;

use Transip\Api\Library\Entity\AbstractEntity;

class AggregatedStatus extends AbstractEntity
{
    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $up;

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getUp(): int
    {
        return $this->up;
    }
}
