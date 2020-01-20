<?php

namespace Transip\Api\Client;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Transip\Api\Client\HttpClient\GuzzleClient;
use Transip\Api\Client\HttpClient\HttpClientInterface;
use Transip\Api\Client\Repository\ApiTestRepository;
use Transip\Api\Client\Repository\AuthRepository;
use Transip\Api\Client\Repository\AvailabilityZoneRepository;
use Transip\Api\Client\Repository\BigStorageRepository;
use Transip\Api\Client\Repository\BigStorage\BackupRepository as BigStorageBackupRepository;
use Transip\Api\Client\Repository\BigStorage\UsageRepository as BigStorageUsageRepository;
use Transip\Api\Client\Repository\ColocationRepository;
use Transip\Api\Client\Repository\Colocation\IpAddressRepository as ColoIpAddressRepository;
use Transip\Api\Client\Repository\Colocation\RemoteHandsRepository as ColoRemoteHandsRepository;
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
use Transip\Api\Client\Repository\Invoice\PdfRepository;
use Transip\Api\Client\Repository\InvoiceRepository;
use Transip\Api\Client\Repository\MailServiceRepository;
use Transip\Api\Client\Repository\PrivateNetworkRepository;
use Transip\Api\Client\Repository\ProductRepository;
use Transip\Api\Client\Repository\DomainTldRepository;
use Transip\Api\Client\Repository\TrafficRepository;
use Transip\Api\Client\Repository\Vps\AddonRepository;
use Transip\Api\Client\Repository\Vps\BackupRepository as VpsBackupRepository;
use Transip\Api\Client\Repository\Vps\FirewallRepository as VpsFirewallRepository;
use Transip\Api\Client\Repository\Vps\IpAddressRepository as VpsIpAddressRepository;
use Transip\Api\Client\Repository\Vps\OperatingSystemRepository;
use Transip\Api\Client\Repository\Vps\SnapshotRepository;
use Transip\Api\Client\Repository\Vps\UpgradeRepository;
use Transip\Api\Client\Repository\Vps\UsageRepository;
use Transip\Api\Client\Repository\Vps\VncDataRepository;
use Transip\Api\Client\Repository\VpsRepository;
use Transip\Api\Client\Repository\Haip\PortConfigurationRepository;
use Transip\Api\Client\Repository\Haip\IpAddressRepository as HaipIpAddressRepository;
use Transip\Api\Client\Repository\Haip\CertificateRepository as HaipCertificateRepository;
use Transip\Api\Client\Repository\Haip\StatusReportRepository;
use Transip\Api\Client\Repository\HaipRepository;

class TransipAPI
{
    public const TRANSIP_API_ENDPOINT = "https://api.transip.nl/v6";
    public const TRANSIP_API_LIBRARY_VERSION = "6.0.0";

    /**
     * @var HttpClientInterface $httpClient
     */
    private $httpClient;

    /**
     * @param string                $customerLoginName           The loginName used to login to the TransIP Control Panel.
     * @param string                $privateKey                  The Privatekey generated in the control panel
     * @param bool                  $generateWhitelistOnlyTokens Whether the generated token should use the whitelist
     * @param string                $token                       AccessToken (optional, private key will generate this for you)
     * @param string                $endpointUrl                 Use a different endpoint
     * @param AdapterInterface|null $cache                       Symphony cache adapter, to hold the generated AccessToken
     */
    public function __construct(
        string $customerLoginName,
        string $privateKey,
        bool $generateWhitelistOnlyTokens = true,
        string $token = '',
        string $endpointUrl = '',
        AdapterInterface $cache = null
    ) {
        $endpoint = self::TRANSIP_API_ENDPOINT;

        if ($endpointUrl != '') {
            $endpoint = $endpointUrl;
        }

        $this->httpClient = new GuzzleClient($endpoint);

        if ($customerLoginName != '') {
            $this->httpClient->setLogin($customerLoginName);
        }

        if ($privateKey != '') {
            $this->httpClient->setPrivateKey($privateKey);
        }

        if ($cache === null) {
            $cache = new FilesystemAdapter();
        }

        $this->httpClient->setCache($cache);
        $this->httpClient->setGenerateWhitelistOnlyTokens($generateWhitelistOnlyTokens);

        if ($token != '') {
            $this->httpClient->setToken($token);
        } else {
            $this->httpClient->getTokenFromCache();
        }
    }

    public function availabilityZone(): AvailabilityZoneRepository
    {
        return new AvailabilityZoneRepository($this->httpClient);
    }

    public function products(): ProductRepository
    {
        return new ProductRepository($this->httpClient);
    }

    public function domains(): DomainRepository
    {
        return new DomainRepository($this->httpClient);
    }

    public function domainAction(): DomainActionRepository
    {
        return new DomainActionRepository($this->httpClient);
    }

    public function domainBranding(): DomainBrandingRepository
    {
        return new DomainBrandingRepository($this->httpClient);
    }

    public function domainContact(): DomainContactRepository
    {
        return new DomainContactRepository($this->httpClient);
    }

    public function domainDns(): DomainDnsRepository
    {
        return new DomainDnsRepository($this->httpClient);
    }

    public function domainDnsSec(): DomainDnsSecRepository
    {
        return new DomainDnsSecRepository($this->httpClient);
    }

    public function domainNameserver(): DomainNameserverRepository
    {
        return new DomainNameserverRepository($this->httpClient);
    }

    public function domainSsl(): DomainSslRepository
    {
        return new DomainSslRepository($this->httpClient);
    }

    public function domainWhois(): DomainWhoisRepository
    {
        return new DomainWhoisRepository($this->httpClient);
    }

    public function domainZoneFile(): DomainZoneFileRepository
    {
        return new DomainZoneFileRepository($this->httpClient);
    }

    public function domainAvailability(): DomainAvailabilityRepository
    {
        return new DomainAvailabilityRepository($this->httpClient);
    }

    public function domainTlds(): DomainTldRepository
    {
        return new DomainTldRepository($this->httpClient);
    }

    public function domainWhitelabel(): DomainWhitelabelRepository
    {
        return new DomainWhitelabelRepository($this->httpClient);
    }

    public function vps(): VpsRepository
    {
        return new VpsRepository($this->httpClient);
    }

    public function traffic(): TrafficRepository
    {
        return new TrafficRepository($this->httpClient);
    }

    public function vpsAddons(): AddonRepository
    {
        return new AddonRepository($this->httpClient);
    }

    public function vpsBackups(): VpsBackupRepository
    {
        return new VpsBackupRepository($this->httpClient);
    }

    public function vpsFirewall(): VpsFirewallRepository
    {
        return new VpsFirewallRepository($this->httpClient);
    }

    public function vpsIpAddresses(): VpsIpAddressRepository
    {
        return new VpsIpAddressRepository($this->httpClient);
    }

    public function vpsOperatingSystems(): OperatingSystemRepository
    {
        return new OperatingSystemRepository($this->httpClient);
    }

    public function vpsSnapshots(): SnapshotRepository
    {
        return new SnapshotRepository($this->httpClient);
    }

    public function vpsUpgrades(): UpgradeRepository
    {
        return new UpgradeRepository($this->httpClient);
    }

    public function vpsUsage(): UsageRepository
    {
        return new UsageRepository($this->httpClient);
    }

    public function vpsVncData(): VncDataRepository
    {
        return new VncDataRepository($this->httpClient);
    }

    public function privateNetworks(): PrivateNetworkRepository
    {
        return new PrivateNetworkRepository($this->httpClient);
    }

    public function bigStorages(): BigStorageRepository
    {
        return new BigStorageRepository($this->httpClient);
    }

    public function bigStorageBackups(): BigStorageBackupRepository
    {
        return new BigStorageBackupRepository($this->httpClient);
    }

    public function bigStorageUsage(): BigStorageUsageRepository
    {
        return new BigStorageUsageRepository($this->httpClient);
    }

    public function mailService(): MailServiceRepository
    {
        return new MailServiceRepository($this->httpClient);
    }

    public function haip(): HaipRepository
    {
        return new HaipRepository($this->httpClient);
    }

    public function haipIpAddresses(): HaipIpAddressRepository
    {
        return new HaipIpAddressRepository($this->httpClient);
    }

    public function haipPortConfigurations(): PortConfigurationRepository
    {
        return new PortConfigurationRepository($this->httpClient);
    }

    public function haipCertificates(): HaipCertificateRepository
    {
        return new HaipCertificateRepository($this->httpClient);
    }

    public function haipStatusReports(): StatusReportRepository
    {
        return new StatusReportRepository($this->httpClient);
    }

    public function colocation(): ColocationRepository
    {
        return new ColocationRepository($this->httpClient);
    }

    public function colocationIpAddress(): ColoIpAddressRepository
    {
        return new ColoIpAddressRepository($this->httpClient);
    }

    public function colocationRemoteHands(): ColoRemoteHandsRepository
    {
        return new ColoRemoteHandsRepository($this->httpClient);
    }

    public function test(): ApiTestRepository
    {
        return new ApiTestRepository($this->httpClient);
    }

    public function auth(): AuthRepository
    {
        return new AuthRepository($this->httpClient);
    }

    public function invoice(): InvoiceRepository
    {
        return new InvoiceRepository($this->httpClient);
    }

    public function invoicePdf(): PdfRepository
    {
        return new PdfRepository($this->httpClient);
    }

    public function setHttpClient(HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function setToken(string $token): void
    {
        $this->httpClient->setToken($token);
    }

    public function setEndpointUrl(string $endpointUrl): void
    {
        $this->httpClient->setEndpoint($endpointUrl);
    }

    public function getLogin(): string
    {
        return $this->httpClient->getLogin();
    }

    public function getEndpointUrl(): string
    {
        return $this->httpClient->getEndpoint();
    }

    public function getGenerateWhitelistOnlyTokens(): bool
    {
        return $this->httpClient->getGenerateWhitelistOnlyTokens();
    }

    public function clearCache(): void
    {
        $this->httpClient->clearCache();
    }

    /**
     * When set to true, all tokens generated will be set to read only mode. This means no purchases or changes can be
     * made using the api.
     *
     * @param bool $mode
     */
    public function setReadOnlyMode(bool $mode = false): void
    {
        $this->httpClient->setReadOnlyMode($mode);
    }
}
