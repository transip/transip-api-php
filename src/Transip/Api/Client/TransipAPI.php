<?php

namespace Transip\Api\Client;

use Transip\Api\Client\HttpClient\GuzzleClient;
use Transip\Api\Client\HttpClient\HttpClientInterface;
use Transip\Api\Client\Repository\AvailabilityZoneRepository;
use Transip\Api\Client\Repository\BigStorageRepository;
use Transip\Api\Client\Repository\BigStorage\BackupRepository as BigStorageBackupRepository;
use Transip\Api\Client\Repository\ColocationRepository;
use Transip\Api\Client\Repository\Colocation\IpAddressRepository as ColoIpAddressRepository;
use Transip\Api\Client\Repository\DomainRepository;
use Transip\Api\Client\Repository\DomainAvailabilityRepository;
use Transip\Api\Client\Repository\Domain\ActionRepository as DomainActionRepository;
use Transip\Api\Client\Repository\Domain\BrandingRepository as DomainBrandingRepository;
use Transip\Api\Client\Repository\Domain\ContactRepository as DomainContactRepository;
use Transip\Api\Client\Repository\Domain\DnsRepository as DomainDnsRepository;
use Transip\Api\Client\Repository\Domain\DnsSecRepository as DomainDnsSecRepository;
use Transip\Api\Client\Repository\Domain\NameserverRepository as DomainNameserverRepository;
use Transip\Api\Client\Repository\Domain\SslRepository as DomainSslRepository;
use Transip\Api\Client\Repository\Domain\WhoisRepository as DomainWhoisRepository;
use Transip\Api\Client\Repository\Domain\ZoneFileRepository as DomainZoneFileRepository;
use Transip\Api\Client\Repository\DomainWhitelabelRepository;
use Transip\Api\Client\Repository\MailServiceRepository;
use Transip\Api\Client\Repository\PrivateNetworkRepository;
use Transip\Api\Client\Repository\ProductRepository;
use Transip\Api\Client\Repository\DomainTldRepository;
use Transip\Api\Client\Repository\TrafficRepository;
use Transip\Api\Client\Repository\Vps\AddonRepository;
use Transip\Api\Client\Repository\Vps\BackupRepository as VpsBackupRepository;
use Transip\Api\Client\Repository\Vps\IpAddressRepository as VpsIpAddressRepository;
use Transip\Api\Client\Repository\Vps\OperatingSystemRepository;
use Transip\Api\Client\Repository\Vps\SnapshotRepository;
use Transip\Api\Client\Repository\Vps\UpgradeRepository;
use Transip\Api\Client\Repository\Vps\UsageRepository;
use Transip\Api\Client\Repository\VpsRepository;
use Transip\Api\Client\Repository\Haip\PortConfigurationRepository;
use Transip\Api\Client\Repository\Haip\IpAddressRepository as HaipIpAddressRepository;
use Transip\Api\Client\Repository\Haip\CertificateRepository as HaipCertificateRepository;
use Transip\Api\Client\Repository\Haip\StatusReportRepository;
use Transip\Api\Client\Repository\HaipRepository;

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

    public function domainAction(): DomainActionRepository
    {
        return new DomainActionRepository($this->httpClient, $this->endpoint);
    }

    public function domainBranding(): DomainBrandingRepository
    {
        return new DomainBrandingRepository($this->httpClient, $this->endpoint);
    }

    public function domainContact(): DomainContactRepository
    {
        return new DomainContactRepository($this->httpClient, $this->endpoint);
    }

    public function domainDns(): DomainDnsRepository
    {
        return new DomainDnsRepository($this->httpClient, $this->endpoint);
    }

    public function domainDnsSec(): DomainDnsSecRepository
    {
        return new DomainDnsSecRepository($this->httpClient, $this->endpoint);
    }

    public function domainNameserver(): DomainNameserverRepository
    {
        return new DomainNameserverRepository($this->httpClient, $this->endpoint);
    }

    public function domainSsl(): DomainSslRepository
    {
        return new DomainSslRepository($this->httpClient, $this->endpoint);
    }

    public function domainWhois(): DomainWhoisRepository
    {
        return new DomainWhoisRepository($this->httpClient, $this->endpoint);
    }

    public function domainZoneFile(): DomainZoneFileRepository
    {
        return new DomainZoneFileRepository($this->httpClient, $this->endpoint);
    }

    public function domainAvailability(): DomainAvailabilityRepository
    {
        return new DomainAvailabilityRepository($this->httpClient, $this->endpoint);
    }

    public function domainTlds(): DomainTldRepository
    {
        return new DomainTldRepository($this->httpClient, $this->endpoint);
    }

    public function domainWhitelabel(): DomainWhitelabelRepository
    {
        return new DomainWhitelabelRepository($this->httpClient, $this->endpoint);
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

    public function vpsIpAddresses(): VpsIpAddressRepository
    {
        return new VpsIpAddressRepository($this->httpClient, $this->endpoint);
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

    public function vpsUsage(): UsageRepository
    {
        return new UsageRepository($this->httpClient, $this->endpoint);
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

    public function haip(): HaipRepository
    {
        return new HaipRepository($this->httpClient, $this->endpoint);
    }

    public function haipIpAddresses(): HaipIpAddressRepository
    {
        return new HaipIpAddressRepository($this->httpClient, $this->endpoint);
    }

    public function haipPortConfigurations(): PortConfigurationRepository
    {
        return new PortConfigurationRepository($this->httpClient, $this->endpoint);
    }

    public function haipCertificates(): HaipCertificateRepository
    {
        return new HaipCertificateRepository($this->httpClient, $this->endpoint);
    }

    public function haipStatusReports(): StatusReportRepository
    {
        return new StatusReportRepository($this->httpClient, $this->endpoint);
    }

    public function colocation(): ColocationRepository
    {
        return new ColocationRepository($this->httpClient, $this->endpoint);
    }

    public function colocationIpAddress(): ColoIpAddressRepository
    {
        return new ColoIpAddressRepository($this->httpClient, $this->endpoint);
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
