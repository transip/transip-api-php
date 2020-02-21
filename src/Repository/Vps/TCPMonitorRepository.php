<?php

namespace Transip\Api\Library\Repository\Vps;

use Transip\Api\Library\Entity\Vps\TCPMonitor;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\VpsRepository;

class TCPMonitorRepository extends ApiRepository
{
    protected const RESOURCE_NAME = 'tcp-monitors';

    protected function getRepositoryResourceNames(): array
    {
        return [VpsRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $vpsName
     * @return TCPMonitor[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $response         = $this->httpClient->get($this->getResourceUrl($vpsName));
        $tcpMonitorsArray = $this->getParameterFromResponse($response, 'tcpMonitors');

        $tcpMonitors = [];
        foreach ($tcpMonitorsArray as $tcpMonitor) {
            $tcpMonitors[] = new TCPMonitor($tcpMonitor);
        }

        return $tcpMonitors;
    }

    public function create(string $vpsName, TCPMonitor $monitor): void
    {
        $this->httpClient->post($this->getResourceUrl($vpsName), ['tcpMonitor' => $monitor]);
    }

    public function update(string $vpsName, TCPMonitor $monitor): void
    {
        $this->httpClient->put($this->getResourceUrl($vpsName, $monitor->getIpAddress()), ['tcpMonitor' => $monitor]);
    }

    public function delete(string $vpsName, string $ipAddress): void
    {
        $this->httpClient->delete($this->getResourceUrl($vpsName, $ipAddress), []);
    }
}
