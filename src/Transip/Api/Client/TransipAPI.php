<?php

namespace Transip\Api\Client;

use Transip\Api\Client\HttpClient\GuzzleClient;
use Transip\Api\Client\HttpClient\HttpClientInterface;
use Transip\Api\Client\Repository\AvailabilityZoneRepository;
use Transip\Api\Client\Repository\BigStorageRepository;
use Transip\Api\Client\Repository\BigStorage\BackupRepository as BigStorageBackupRepository;
use Transip\Api\Client\Repository\DomainRepository;
use Transip\Api\Client\Repository\MailServiceRepository;
use Transip\Api\Client\Repository\PrivateNetworkRepository;
use Transip\Api\Client\Repository\ProductRepository;
use Transip\Api\Client\Repository\TrafficRepository;
use Transip\Api\Client\Repository\Vps\AddonRepository;
use Transip\Api\Client\Repository\Vps\BackupRepository as VpsBackupRepository;
use Transip\Api\Client\Repository\Vps\IpAddressRepository;
use Transip\Api\Client\Repository\Vps\OperatingSystemRepository;
use Transip\Api\Client\Repository\Vps\SnapshotRepository;
use Transip\Api\Client\Repository\Vps\UpgradeRepository;
use Transip\Api\Client\Repository\VpsRepository;

class TransipAPI
{
    private const TRANSIP_API_ENDPOINT = "https://api.transip.nl/v6";

    /**
     * @var HttpClientInterface $httpClient
     */
    private $httpClient;

    /**
     * @var string $endpoint
     */
    private $endpoint;

    /**
     * @var string $token
     */
    private $token = '';


    public function __construct(string $token = '', string $endpointUrl = '')
    {
        $this->endpoint = self::TRANSIP_API_ENDPOINT;

        if ($token != '') {
            $this->token = $token;
        }

        if ($endpointUrl != '') {
            $this->endpoint = $endpointUrl;
        }

        $this->httpClient = new GuzzleClient($this->token);
    }

    public function availabilityZone(): AvailabilityZoneRepository
    {
        return new AvailabilityZoneRepository($this->httpClient, $this->endpoint);
    }

    public function products(): ProductRepository
    {
        return new ProductRepository($this->httpClient, $this->endpoint);
    }

    public function domains(): DomainRepository
    {
        return new DomainRepository($this->httpClient, $this->endpoint);
    }

    public function vps(): VpsRepository
    {
        return new VpsRepository($this->httpClient, $this->endpoint);
    }

    public function traffic(): TrafficRepository
    {
        return new TrafficRepository($this->httpClient, $this->endpoint);
    }

    public function vpsAddons(): AddonRepository
    {
        return new AddonRepository($this->httpClient, $this->endpoint);
    }

    public function vpsBackups(): VpsBackupRepository
    {
        return new VpsBackupRepository($this->httpClient, $this->endpoint);
    }

    public function vpsIpAddresses(): IpAddressRepository
    {
        return new IpAddressRepository($this->httpClient, $this->endpoint);
    }

    public function vpsOperatingSystems(): OperatingSystemRepository
    {
        return new OperatingSystemRepository($this->httpClient, $this->endpoint);
    }

    public function vpsSnapshots(): SnapshotRepository
    {
        return new SnapshotRepository($this->httpClient, $this->endpoint);
    }

    public function vpsUpgrades(): UpgradeRepository
    {
        return new UpgradeRepository($this->httpClient, $this->endpoint);
    }

    public function privateNetworks(): PrivateNetworkRepository
    {
        return new PrivateNetworkRepository($this->httpClient, $this->endpoint);
    }

    public function bigStorages(): BigStorageRepository
    {
        return new BigStorageRepository($this->httpClient, $this->endpoint);
    }

    public function bigStorageBackups(): BigStorageBackupRepository
    {
        return new BigStorageBackupRepository($this->httpClient, $this->endpoint);
    }

    public function mailService(): MailServiceRepository
    {
        return new MailServiceRepository($this->httpClient, $this->endpoint);
    }

    public function setHttpClient(HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
        $httpClientClass = get_class($this->httpClient);
        $this->httpClient = new $httpClientClass($this->token);
    }
}
