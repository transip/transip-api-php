<?php

namespace Transip\Api\Library;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Transip\Api\Library\HttpClient\GuzzleClient;
use Transip\Api\Library\HttpClient\HttpClient;
use Transip\Api\Library\HttpClient\HttpClientInterface;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\ApiTestRepository;
use Transip\Api\Library\Repository\AuthRepository;
use Transip\Api\Library\Repository\AvailabilityZoneRepository;
use Transip\Api\Library\Repository\BigStorageRepository;
use Transip\Api\Library\Repository\BigStorage\BackupRepository as BigStorageBackupRepository;
use Transip\Api\Library\Repository\BigStorage\UsageRepository as BigStorageUsageRepository;
use Transip\Api\Library\Repository\ColocationRepository;
use Transip\Api\Library\Repository\Colocation\IpAddressRepository as ColoIpAddressRepository;
use Transip\Api\Library\Repository\Colocation\RemoteHandsRepository as ColoRemoteHandsRepository;
use Transip\Api\Library\Repository\DomainRepository;
use Transip\Api\Library\Repository\DomainAvailabilityRepository;
use Transip\Api\Library\Repository\Domain\ActionRepository as DomainActionRepository;
use Transip\Api\Library\Repository\Domain\BrandingRepository as DomainBrandingRepository;
use Transip\Api\Library\Repository\Domain\ContactRepository as DomainContactRepository;
use Transip\Api\Library\Repository\Domain\DnsRepository as DomainDnsRepository;
use Transip\Api\Library\Repository\Domain\DnsSecRepository as DomainDnsSecRepository;
use Transip\Api\Library\Repository\Domain\NameserverRepository as DomainNameserverRepository;
use Transip\Api\Library\Repository\Domain\SslRepository as DomainSslRepository;
use Transip\Api\Library\Repository\Domain\WhoisRepository as DomainWhoisRepository;
use Transip\Api\Library\Repository\DomainWhitelabelRepository;
use Transip\Api\Library\Repository\InvoiceRepository;
use Transip\Api\Library\Repository\Invoice\ItemRepository as InvoiceItemRepository;
use Transip\Api\Library\Repository\Invoice\PdfRepository as InvoicePdfRepository;
use Transip\Api\Library\Repository\MailServiceRepository;
use Transip\Api\Library\Repository\OpenStack\ProjectRepository as OpenStackProjectRepository;
use Transip\Api\Library\Repository\OpenStack\UserRepository as OpenStackUserRepository;
use Transip\Api\Library\Repository\OpenStack\Project\UserRepository as OpenStackProjectUserRepository;
use Transip\Api\Library\Repository\PrivateNetworkRepository;
use Transip\Api\Library\Repository\ProductRepository;
use Transip\Api\Library\Repository\Product\ElementRepository as ProductElementRepository;
use Transip\Api\Library\Repository\DomainTldRepository;
use Transip\Api\Library\Repository\SshKeyRepository;
use Transip\Api\Library\Repository\TrafficPoolRepository;
use Transip\Api\Library\Repository\TrafficRepository;
use Transip\Api\Library\Repository\Vps\AddonRepository;
use Transip\Api\Library\Repository\Vps\BackupRepository as VpsBackupRepository;
use Transip\Api\Library\Repository\Vps\LicenseRepository;
use Transip\Api\Library\Repository\Vps\MonitoringContactRepository;
use Transip\Api\Library\Repository\Vps\FirewallRepository as VpsFirewallRepository;
use Transip\Api\Library\Repository\Vps\IpAddressRepository as VpsIpAddressRepository;
use Transip\Api\Library\Repository\Vps\OperatingSystemRepository;
use Transip\Api\Library\Repository\Vps\SnapshotRepository;
use Transip\Api\Library\Repository\Vps\TCPMonitorRepository;
use Transip\Api\Library\Repository\Vps\UpgradeRepository;
use Transip\Api\Library\Repository\Vps\UsageRepository;
use Transip\Api\Library\Repository\Vps\VncDataRepository;
use Transip\Api\Library\Repository\VpsRepository;
use Transip\Api\Library\Repository\Haip\PortConfigurationRepository;
use Transip\Api\Library\Repository\Haip\IpAddressRepository as HaipIpAddressRepository;
use Transip\Api\Library\Repository\Haip\CertificateRepository as HaipCertificateRepository;
use Transip\Api\Library\Repository\Haip\StatusReportRepository;
use Transip\Api\Library\Repository\HaipRepository;

class TransipAPI
{
    public const TRANSIP_API_ENDPOINT = "https://api.transip.nl/v6";
    public const TRANSIP_API_LIBRARY_VERSION = "6.12.0";
    public const TRANSIP_API_DEMO_TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImN3MiFSbDU2eDNoUnkjelM4YmdOIn0.eyJpc3MiOiJhcGkudHJhbnNpcC5ubCIsImF1ZCI6ImFwaS50cmFuc2lwLm5sIiwianRpIjoiY3cyIVJsNTZ4M2hSeSN6UzhiZ04iLCJpYXQiOjE1ODIyMDE1NTAsIm5iZiI6MTU4MjIwMTU1MCwiZXhwIjoyMTE4NzQ1NTUwLCJjaWQiOiI2MDQ0OSIsInJvIjpmYWxzZSwiZ2siOmZhbHNlLCJrdiI6dHJ1ZX0.fYBWV4O5WPXxGuWG-vcrFWqmRHBm9yp0PHiYh_oAWxWxCaZX2Rf6WJfc13AxEeZ67-lY0TA2kSaOCp0PggBb_MGj73t4cH8gdwDJzANVxkiPL1Saqiw2NgZ3IHASJnisUWNnZp8HnrhLLe5ficvb1D9WOUOItmFC2ZgfGObNhlL2y-AMNLT4X7oNgrNTGm-mespo0jD_qH9dK5_evSzS3K8o03gu6p19jxfsnIh8TIVRvNdluYC2wo4qDl5EW5BEZ8OSuJ121ncOT1oRpzXB0cVZ9e5_UVAEr9X3f26_Eomg52-PjrgcRJ_jPIUYbrlo06KjjX2h0fzMr21ZE023Gw";

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
        AdapterInterface $cache = null,
        HttpClient $httpClient = null
    ) {
        $endpoint = self::TRANSIP_API_ENDPOINT;

        if ($endpointUrl != '') {
            $endpoint = $endpointUrl;
        }

        $this->httpClient = $httpClient ?? new GuzzleClient($endpoint);

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

    public function productElements(): ProductElementRepository
    {
        return new ProductElementRepository($this->httpClient);
    }

    public function sshKey(): SshKeyRepository
    {
        return new SshKeyRepository($this->httpClient);
    }

    public function invoice(): InvoiceRepository
    {
        return new InvoiceRepository($this->httpClient);
    }

    public function invoicePdf(): InvoicePdfRepository
    {
        return new InvoicePdfRepository($this->httpClient);
    }

    public function invoiceItem(): InvoiceItemRepository
    {
        return new InvoiceItemRepository($this->httpClient);
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

    /**
     * @deprecated deprecated since version 6.8.0, use trafficPool instead
     */
    public function traffic(): TrafficRepository
    {
        return new TrafficRepository($this->httpClient);
    }

    public function trafficPool(): TrafficPoolRepository
    {
        return new TrafficPoolRepository($this->httpClient);
    }

    public function vps(): VpsRepository
    {
        return new VpsRepository($this->httpClient);
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

    public function vpsTCPMonitor(): TCPMonitorRepository
    {
        return new TCPMonitorRepository($this->httpClient);
    }

    public function vpsTCPMonitorContact(): MonitoringContactRepository
    {
        return new MonitoringContactRepository($this->httpClient);
    }

    public function vpsLicenses(): LicenseRepository
    {
        return new LicenseRepository($this->httpClient);
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

    public function openStackProjects(): OpenStackProjectRepository
    {
        return new OpenStackProjectRepository($this->httpClient);
    }

    public function openStackProjectUsers(): OpenStackProjectUserRepository
    {
        return new OpenStackProjectUserRepository($this->httpClient);
    }

    public function openStackUsers(): OpenStackUserRepository
    {
        return new OpenStackUserRepository($this->httpClient);
    }

    public function test(): ApiTestRepository
    {
        return new ApiTestRepository($this->httpClient);
    }

    public function auth(): AuthRepository
    {
        return new AuthRepository($this->httpClient);
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

    public function setTokenLabelPrefix(string $endpointUrl): void
    {
        $this->httpClient->setTokenLabelPrefix($endpointUrl);
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

    public function getReadOnlyMode(): bool
    {
        return $this->httpClient->getReadOnlyMode();
    }

    public function useDemoToken(): void
    {
        $this->setToken(self::TRANSIP_API_DEMO_TOKEN);
    }

    public function setTestMode(bool $testMode): void
    {
        $this->httpClient->setTestMode($testMode);
    }

    public function getTestMode(): bool
    {
        return $this->httpClient->getTestMode();
    }

    /**
     * The maximum amount of requests
     *
     * @return int
     */
    public function getRateLimitLimit(): int
    {
        return $this->httpClient->getRateLimitLimit();
    }

    /**
     * The amount request remaining till the limit is reached
     *
     * @return int
     */
    public function getRateLimitRemaining(): int
    {
        return $this->httpClient->getRateLimitRemaining();
    }

    /**
     * Timestamp the rate limit will be reset to maximum
     *
     * @return int
     */
    public function getRateLimitReset(): int
    {
        return $this->httpClient->getRateLimitReset();
    }

    public function getTokenExpiryTime(): string
    {
        return $this->httpClient->getChosenTokenExpiry();
    }

    /**
     * You are able to set a expiry time for the token that is generated after authentication. The following options are
     * allowed $expiryTime: '30 minutes', '1 hour', '1 day', '1 week', '2 weeks', '1 month'
     *
     * This is set to '1 day' by default
     *
     * @param string $expiryTime
     */
    public function setTokenExpiryTime(string $expiryTime): void
    {
        $this->httpClient->setChosenTokenExpiry($expiryTime);
    }
}
