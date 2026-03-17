<?php

declare(strict_types=1);

namespace Transip\Api\MCP\Tools;

use Closure;
use Transip\Api\Library\TransipAPI;
use Transip\Api\Library\Entity\Domain\DnsEntry;
use Transip\Api\Library\Entity\Domain\DnsSecEntry;
use Transip\Api\Library\Entity\Domain\Nameserver;

class ToolRegistry
{
    /** @var array<string, array{definition: array<string, mixed>, executor: Closure}> */
    private array $tools = [];

    public function __construct()
    {
        $this->registerAllTools();
    }

    /** @return array<int, array<string, mixed>> */
    public function getDefinitions(): array
    {
        $definitions = [];
        foreach ($this->tools as $tool) {
            $definitions[] = $tool['definition'];
        }
        return $definitions;
    }

    public function getExecutor(string $name): ?Closure
    {
        return $this->tools[$name]['executor'] ?? null;
    }

    private function register(string $name, string $description, array $inputSchema, Closure $executor): void
    {
        $schema = [
            'type' => 'object',
            'properties' => $inputSchema['properties'] ?? [],
        ];
        if (!empty($inputSchema['required'])) {
            $schema['required'] = $inputSchema['required'];
        }

        $this->tools[$name] = [
            'definition' => [
                'name' => $name,
                'description' => $description,
                'inputSchema' => $schema,
            ],
            'executor' => $executor,
        ];
    }

    private function registerAllTools(): void
    {
        $this->registerTestTools();
        $this->registerProductTools();
        $this->registerAvailabilityZoneTools();
        $this->registerVpsTools();
        $this->registerVpsAddonTools();
        $this->registerVpsBackupTools();
        $this->registerVpsFirewallTools();
        $this->registerVpsIpAddressTools();
        $this->registerVpsOperatingSystemTools();
        $this->registerVpsSnapshotTools();
        $this->registerVpsUsageTools();
        $this->registerVpsSettingTools();
        $this->registerVpsLicenseTools();
        $this->registerVpsTcpMonitorTools();
        $this->registerVpsVncTools();
        $this->registerVpsRescueImageTools();
        $this->registerVpsUpgradeTools();
        $this->registerDomainTools();
        $this->registerDomainDnsTools();
        $this->registerDomainDnsSecTools();
        $this->registerDomainNameserverTools();
        $this->registerDomainContactTools();
        $this->registerDomainWhoisTools();
        $this->registerDomainBrandingTools();
        $this->registerDomainSslTools();
        $this->registerDomainActionTools();
        $this->registerDomainAuthCodeTools();
        $this->registerDomainAvailabilityTools();
        $this->registerDomainTldTools();
        $this->registerDomainWhitelabelTools();
        $this->registerDefaultDomainContactTools();
        $this->registerSshKeyTools();
        $this->registerSslCertificateTools();
        $this->registerInvoiceTools();
        $this->registerBlockStorageTools();
        $this->registerBlockStorageBackupTools();
        $this->registerBlockStorageUsageTools();
        $this->registerPrivateNetworkTools();
        $this->registerHaipTools();
        $this->registerHaipCertificateTools();
        $this->registerHaipIpAddressTools();
        $this->registerHaipPortConfigurationTools();
        $this->registerHaipStatusReportTools();
        $this->registerColocationTools();
        $this->registerMailServiceTools();
        $this->registerMailboxTools();
        $this->registerMailForwardTools();
        $this->registerMailListTools();
        $this->registerMailPackageTools();
        $this->registerMailAddonTools();
        $this->registerKubernetesClusterTools();
        $this->registerKubernetesNodeTools();
        $this->registerKubernetesNodePoolTools();
        $this->registerKubernetesBlockStorageTools();
        $this->registerKubernetesEventTools();
        $this->registerKubernetesLoadBalancerTools();
        $this->registerKubernetesProductTools();
        $this->registerKubernetesReleaseTools();
        $this->registerKubernetesLabelTools();
        $this->registerKubernetesTaintTools();
        $this->registerKubernetesKubeConfigTools();
        $this->registerOpenStackTools();
        $this->registerTrafficPoolTools();
        $this->registerActionTools();
        $this->registerAcronisTools();
        $this->registerContactKeyTools();
    }

    private function serializeResult(mixed $result): mixed
    {
        if (is_array($result)) {
            return array_map(fn ($item) => $this->serializeResult($item), $result);
        }
        if (is_object($result) && method_exists($result, 'jsonSerialize')) {
            return $result->jsonSerialize();
        }
        return $result;
    }

    // ==================== Test ====================

    private function registerTestTools(): void
    {
        $this->register(
            'transip_test',
            'Test the API connection to TransIP',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $api->test()->test();
            }
        );
    }

    // ==================== Products ====================

    private function registerProductTools(): void
    {
        $this->register(
            'transip_products_get_all',
            'Get all available TransIP products',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->products()->getAll());
            }
        );

        $this->register(
            'transip_product_elements_get',
            'Get product elements for a specific product',
            [
                'properties' => [
                    'productName' => ['type' => 'string', 'description' => 'Product name'],
                ],
                'required' => ['productName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->productElements()->getByProductName($args['productName']));
            }
        );
    }

    // ==================== Availability Zones ====================

    private function registerAvailabilityZoneTools(): void
    {
        $this->register(
            'transip_availability_zones_get_all',
            'Get all availability zones',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->availabilityZone()->getAll());
            }
        );
    }

    // ==================== VPS ====================

    private function registerVpsTools(): void
    {
        $this->register(
            'transip_vps_get_all',
            'Get all VPS instances',
            ['properties' => [
                'page' => ['type' => 'integer', 'description' => 'Page number (optional)'],
                'itemsPerPage' => ['type' => 'integer', 'description' => 'Items per page (optional)'],
            ]],
            function (TransipAPI $api, array $args): mixed {
                if (isset($args['page']) && isset($args['itemsPerPage'])) {
                    return $this->serializeResult($api->vps()->getSelection((int)$args['page'], (int)$args['itemsPerPage']));
                }
                return $this->serializeResult($api->vps()->getAll());
            }
        );

        $this->register(
            'transip_vps_get_by_name',
            'Get a VPS by its name or UUID',
            [
                'properties' => [
                    'identifier' => ['type' => 'string', 'description' => 'VPS name or UUID'],
                ],
                'required' => ['identifier'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vps()->getByIdentifier($args['identifier']));
            }
        );

        $this->register(
            'transip_vps_get_by_tags',
            'Get VPS instances filtered by tag names',
            [
                'properties' => [
                    'tags' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'Tag names to filter by'],
                ],
                'required' => ['tags'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vps()->getByTagNames($args['tags']));
            }
        );

        $this->register(
            'transip_vps_order',
            'Order a new VPS',
            [
                'properties' => [
                    'productName' => ['type' => 'string', 'description' => 'Product name for the VPS'],
                    'operatingSystem' => ['type' => 'string', 'description' => 'Operating system name (optional)'],
                    'addons' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'List of addon names (optional)'],
                    'hostname' => ['type' => 'string', 'description' => 'Hostname (optional)'],
                    'availabilityZone' => ['type' => 'string', 'description' => 'Availability zone (optional)'],
                    'description' => ['type' => 'string', 'description' => 'Description (optional)'],
                    'installFlavour' => ['type' => 'string', 'description' => 'Install flavour (optional)'],
                    'username' => ['type' => 'string', 'description' => 'Username (optional)'],
                    'sshKeys' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'SSH keys (optional)'],
                ],
                'required' => ['productName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->order(
                    $args['productName'],
                    $args['operatingSystem'] ?? '',
                    $args['addons'] ?? [],
                    $args['hostname'] ?? '',
                    $args['availabilityZone'] ?? '',
                    $args['description'] ?? '',
                    '',
                    $args['installFlavour'] ?? '',
                    $args['username'] ?? '',
                    $args['sshKeys'] ?? []
                );
                return ['success' => true, 'message' => 'VPS order placed'];
            }
        );

        $this->register(
            'transip_vps_order_multiple',
            'Order multiple VPS instances at once',
            [
                'properties' => [
                    'vpss' => ['type' => 'array', 'description' => 'Array of VPS order specifications'],
                ],
                'required' => ['vpss'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->orderMultiple($args['vpss']);
                return ['success' => true, 'message' => 'Multiple VPS orders placed'];
            }
        );

        $this->register(
            'transip_vps_clone',
            'Clone an existing VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'Name of VPS to clone'],
                    'availabilityZone' => ['type' => 'string', 'description' => 'Target availability zone (optional)'],
                ],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->cloneVps($args['vpsName'], $args['availabilityZone'] ?? '');
                return ['success' => true, 'message' => 'VPS clone initiated'];
            }
        );

        $this->register(
            'transip_vps_update',
            'Update a VPS (description, tags, customer lock)',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'description' => ['type' => 'string', 'description' => 'New description (optional)'],
                    'tags' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'Tags (optional)'],
                    'isCustomerLocked' => ['type' => 'boolean', 'description' => 'Customer lock status (optional)'],
                ],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $vps = $api->vps()->getByName($args['vpsName']);
                if (isset($args['description'])) {
                    $vps->setDescription($args['description']);
                }
                if (isset($args['isCustomerLocked'])) {
                    $vps->setIsCustomerLocked($args['isCustomerLocked']);
                }
                $api->vps()->update($vps);
                return ['success' => true, 'message' => 'VPS updated'];
            }
        );

        $this->register(
            'transip_vps_start',
            'Start a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->start($args['vpsName']);
                return ['success' => true, 'message' => 'VPS start initiated'];
            }
        );

        $this->register(
            'transip_vps_stop',
            'Stop a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->stop($args['vpsName']);
                return ['success' => true, 'message' => 'VPS stopped'];
            }
        );

        $this->register(
            'transip_vps_reset',
            'Reset a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->reset($args['vpsName']);
                return ['success' => true, 'message' => 'VPS reset initiated'];
            }
        );

        $this->register(
            'transip_vps_handover',
            'Handover a VPS to another customer',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'targetCustomerName' => ['type' => 'string', 'description' => 'Target customer login name'],
                ],
                'required' => ['vpsName', 'targetCustomerName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->handover($args['vpsName'], $args['targetCustomerName']);
                return ['success' => true, 'message' => 'VPS handover initiated'];
            }
        );

        $this->register(
            'transip_vps_cancel',
            'Cancel a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'endTime' => ['type' => 'string', 'description' => 'End time: "end" (end of contract) or "immediately"'],
                ],
                'required' => ['vpsName', 'endTime'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vps()->cancel($args['vpsName'], $args['endTime']);
                return ['success' => true, 'message' => 'VPS cancellation initiated'];
            }
        );
    }

    // ==================== VPS Addons ====================

    private function registerVpsAddonTools(): void
    {
        $this->register(
            'transip_vps_addons_get',
            'Get available addons for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsAddons()->getByVpsName($args['vpsName']));
            }
        );

        $this->register(
            'transip_vps_addons_order',
            'Order addons for a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'addons' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'Addon names to order'],
                ],
                'required' => ['vpsName', 'addons'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsAddons()->order($args['vpsName'], $args['addons']);
                return ['success' => true, 'message' => 'VPS addons ordered'];
            }
        );

        $this->register(
            'transip_vps_addons_cancel',
            'Cancel a VPS addon',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'addonName' => ['type' => 'string', 'description' => 'Addon name to cancel'],
                ],
                'required' => ['vpsName', 'addonName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsAddons()->cancel($args['vpsName'], $args['addonName']);
                return ['success' => true, 'message' => 'VPS addon cancelled'];
            }
        );
    }

    // ==================== VPS Backups ====================

    private function registerVpsBackupTools(): void
    {
        $this->register(
            'transip_vps_backups_get',
            'Get backups for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsBackups()->getByVpsName($args['vpsName']));
            }
        );

        $this->register(
            'transip_vps_backups_revert',
            'Revert a VPS backup',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'backupId' => ['type' => 'integer', 'description' => 'Backup ID'],
                    'destinationVpsIdentifier' => ['type' => 'string', 'description' => 'Target VPS name/UUID to restore to (optional)'],
                ],
                'required' => ['vpsName', 'backupId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsBackups()->revertBackup($args['vpsName'], (int)$args['backupId'], $args['destinationVpsIdentifier'] ?? null);
                return ['success' => true, 'message' => 'VPS backup revert initiated'];
            }
        );

        $this->register(
            'transip_vps_backups_convert_to_snapshot',
            'Convert a VPS backup to a snapshot',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'backupId' => ['type' => 'integer', 'description' => 'Backup ID'],
                    'description' => ['type' => 'string', 'description' => 'Snapshot description (optional)'],
                ],
                'required' => ['vpsName', 'backupId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsBackups()->convertBackupToSnapshot($args['vpsName'], (int)$args['backupId'], $args['description'] ?? '');
                return ['success' => true, 'message' => 'Backup converted to snapshot'];
            }
        );
    }

    // ==================== VPS Firewall ====================

    private function registerVpsFirewallTools(): void
    {
        $this->register(
            'transip_vps_firewall_get',
            'Get the firewall configuration for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsFirewall()->getByVpsName($args['vpsName']));
            }
        );

        $this->register(
            'transip_vps_firewall_reset',
            'Reset the firewall for a VPS to defaults',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsFirewall()->reset($args['vpsName']);
                return ['success' => true, 'message' => 'Firewall reset'];
            }
        );
    }

    // ==================== VPS IP Addresses ====================

    private function registerVpsIpAddressTools(): void
    {
        $this->register(
            'transip_vps_ip_addresses_get',
            'Get all IP addresses for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsIpAddresses()->getByVpsName($args['vpsName']));
            }
        );

        $this->register(
            'transip_vps_ip_address_get',
            'Get a specific IP address for a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'ipAddress' => ['type' => 'string', 'description' => 'IP address'],
                ],
                'required' => ['vpsName', 'ipAddress'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsIpAddresses()->getByVpsNameAddress($args['vpsName'], $args['ipAddress']));
            }
        );

        $this->register(
            'transip_vps_ip_address_add_ipv6',
            'Add an IPv6 address to a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'ipv6Address' => ['type' => 'string', 'description' => 'IPv6 address to add'],
                ],
                'required' => ['vpsName', 'ipv6Address'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsIpAddresses()->addIpv6Address($args['vpsName'], $args['ipv6Address']);
                return ['success' => true, 'message' => 'IPv6 address added'];
            }
        );

        $this->register(
            'transip_vps_ip_address_remove_ipv6',
            'Remove an IPv6 address from a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'ipv6Address' => ['type' => 'string', 'description' => 'IPv6 address to remove'],
                ],
                'required' => ['vpsName', 'ipv6Address'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsIpAddresses()->removeIpv6Address($args['vpsName'], $args['ipv6Address']);
                return ['success' => true, 'message' => 'IPv6 address removed'];
            }
        );
    }

    // ==================== VPS Operating Systems ====================

    private function registerVpsOperatingSystemTools(): void
    {
        $this->register(
            'transip_vps_operating_systems_get_all',
            'Get all available operating systems',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsOperatingSystems()->getAll());
            }
        );

        $this->register(
            'transip_vps_operating_systems_get_by_vps',
            'Get operating systems available for a specific VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsOperatingSystems()->getByVpsName($args['vpsName']));
            }
        );

        $this->register(
            'transip_vps_operating_system_install',
            'Install an operating system on a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'operatingSystemName' => ['type' => 'string', 'description' => 'OS name to install'],
                    'hostname' => ['type' => 'string', 'description' => 'Hostname (optional)'],
                    'installFlavour' => ['type' => 'string', 'description' => 'Install flavour (optional)'],
                    'username' => ['type' => 'string', 'description' => 'Username (optional)'],
                    'sshKeys' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'SSH keys (optional)'],
                ],
                'required' => ['vpsName', 'operatingSystemName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsOperatingSystems()->install(
                    $args['vpsName'],
                    $args['operatingSystemName'],
                    $args['hostname'] ?? '',
                    '',
                    $args['installFlavour'] ?? '',
                    $args['username'] ?? '',
                    $args['sshKeys'] ?? []
                );
                return ['success' => true, 'message' => 'OS installation initiated'];
            }
        );
    }

    // ==================== VPS Snapshots ====================

    private function registerVpsSnapshotTools(): void
    {
        $this->register(
            'transip_vps_snapshots_get',
            'Get all snapshots for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsSnapshots()->getByVpsName($args['vpsName']));
            }
        );

        $this->register(
            'transip_vps_snapshot_get',
            'Get a specific snapshot for a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'snapshotName' => ['type' => 'string', 'description' => 'Snapshot name'],
                ],
                'required' => ['vpsName', 'snapshotName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsSnapshots()->getByVpsNameSnapshotName($args['vpsName'], $args['snapshotName']));
            }
        );

        $this->register(
            'transip_vps_snapshot_create',
            'Create a snapshot for a VPS',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'description' => ['type' => 'string', 'description' => 'Snapshot description'],
                    'shouldStartVps' => ['type' => 'boolean', 'description' => 'Whether to start VPS after snapshot (default: true)'],
                ],
                'required' => ['vpsName', 'description'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsSnapshots()->createSnapshot($args['vpsName'], $args['description'], $args['shouldStartVps'] ?? true);
                return ['success' => true, 'message' => 'Snapshot creation initiated'];
            }
        );

        $this->register(
            'transip_vps_snapshot_revert',
            'Revert a VPS to a snapshot',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'snapshotName' => ['type' => 'string', 'description' => 'Snapshot name'],
                    'destinationVpsName' => ['type' => 'string', 'description' => 'Destination VPS name (optional)'],
                ],
                'required' => ['vpsName', 'snapshotName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsSnapshots()->revertSnapshot($args['vpsName'], $args['snapshotName'], $args['destinationVpsName'] ?? '');
                return ['success' => true, 'message' => 'Snapshot revert initiated'];
            }
        );

        $this->register(
            'transip_vps_snapshot_delete',
            'Delete a VPS snapshot',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'snapshotName' => ['type' => 'string', 'description' => 'Snapshot name'],
                ],
                'required' => ['vpsName', 'snapshotName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->vpsSnapshots()->deleteSnapshot($args['vpsName'], $args['snapshotName']);
                return ['success' => true, 'message' => 'Snapshot deleted'];
            }
        );
    }

    // ==================== VPS Usage ====================

    private function registerVpsUsageTools(): void
    {
        $this->register(
            'transip_vps_usage_get',
            'Get usage statistics for a VPS (cpu, disk, network)',
            [
                'properties' => [
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name'],
                    'types' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'Usage types: cpu, disk, network (optional)'],
                    'dateTimeStart' => ['type' => 'integer', 'description' => 'Start timestamp (optional)'],
                    'dateTimeEnd' => ['type' => 'integer', 'description' => 'End timestamp (optional)'],
                ],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsUsage()->getByVpsName(
                    $args['vpsName'],
                    $args['types'] ?? [],
                    (int)($args['dateTimeStart'] ?? 0),
                    (int)($args['dateTimeEnd'] ?? 0)
                ));
            }
        );
    }

    // ==================== VPS Settings ====================

    private function registerVpsSettingTools(): void
    {
        $this->register(
            'transip_vps_settings_get',
            'Get settings for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsSettings()->getByVpsName($args['vpsName']));
            }
        );
    }

    // ==================== VPS Licenses ====================

    private function registerVpsLicenseTools(): void
    {
        $this->register(
            'transip_vps_licenses_get',
            'Get licenses for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsLicenses()->getByVpsName($args['vpsName']));
            }
        );
    }

    // ==================== VPS TCP Monitor ====================

    private function registerVpsTcpMonitorTools(): void
    {
        $this->register(
            'transip_vps_tcp_monitors_get',
            'Get TCP monitors for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsTCPMonitor()->getByVpsName($args['vpsName']));
            }
        );
    }

    // ==================== VPS VNC ====================

    private function registerVpsVncTools(): void
    {
        $this->register(
            'transip_vps_vnc_data_get',
            'Get VNC connection data for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsVncData()->getByVpsName($args['vpsName']));
            }
        );
    }

    // ==================== VPS Rescue Images ====================

    private function registerVpsRescueImageTools(): void
    {
        $this->register(
            'transip_vps_rescue_images_get',
            'Get available rescue images for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsRescueImages()->getByVpsName($args['vpsName']));
            }
        );
    }

    // ==================== VPS Upgrades ====================

    private function registerVpsUpgradeTools(): void
    {
        $this->register(
            'transip_vps_upgrades_get',
            'Get available upgrades for a VPS',
            [
                'properties' => ['vpsName' => ['type' => 'string', 'description' => 'VPS name']],
                'required' => ['vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->vpsUpgrades()->getByVpsName($args['vpsName']));
            }
        );
    }

    // ==================== Domains ====================

    private function registerDomainTools(): void
    {
        $this->register(
            'transip_domains_get_all',
            'Get all domains in the account',
            [
                'properties' => [
                    'page' => ['type' => 'integer', 'description' => 'Page number (optional)'],
                    'itemsPerPage' => ['type' => 'integer', 'description' => 'Items per page (optional)'],
                ],
            ],
            function (TransipAPI $api, array $args): mixed {
                if (isset($args['page']) && isset($args['itemsPerPage'])) {
                    return $this->serializeResult($api->domains()->getSelection((int)$args['page'], (int)$args['itemsPerPage']));
                }
                return $this->serializeResult($api->domains()->getAll());
            }
        );

        $this->register(
            'transip_domain_get_by_name',
            'Get a domain by its name',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domains()->getByName($args['domainName']));
            }
        );

        $this->register(
            'transip_domains_get_by_tags',
            'Get domains filtered by tag names',
            [
                'properties' => [
                    'tags' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'Tag names'],
                ],
                'required' => ['tags'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domains()->getByTagNames($args['tags']));
            }
        );

        $this->register(
            'transip_domain_register',
            'Register a new domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name to register'],
                ],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->domains()->register($args['domainName']);
                return ['success' => true, 'message' => 'Domain registration initiated'];
            }
        );

        $this->register(
            'transip_domain_transfer',
            'Transfer a domain to TransIP',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'authCode' => ['type' => 'string', 'description' => 'Authorization/transfer code'],
                ],
                'required' => ['domainName', 'authCode'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->domains()->transfer($args['domainName'], $args['authCode']);
                return ['success' => true, 'message' => 'Domain transfer initiated'];
            }
        );

        $this->register(
            'transip_domain_cancel',
            'Cancel a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'endTime' => ['type' => 'string', 'description' => 'End time: "end" or "immediately"'],
                ],
                'required' => ['domainName', 'endTime'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->domains()->cancel($args['domainName'], $args['endTime']);
                return ['success' => true, 'message' => 'Domain cancellation initiated'];
            }
        );
    }

    // ==================== Domain DNS ====================

    private function registerDomainDnsTools(): void
    {
        $this->register(
            'transip_domain_dns_get',
            'Get DNS entries for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainDns()->getByDomainName($args['domainName']));
            }
        );

        $this->register(
            'transip_domain_dns_add',
            'Add a DNS entry to a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'name' => ['type' => 'string', 'description' => 'DNS entry name (e.g., @, www)'],
                    'expire' => ['type' => 'integer', 'description' => 'TTL in seconds'],
                    'type' => ['type' => 'string', 'description' => 'Record type: A, AAAA, CNAME, MX, NS, TXT, SRV, etc.'],
                    'content' => ['type' => 'string', 'description' => 'Record content/value'],
                ],
                'required' => ['domainName', 'name', 'expire', 'type', 'content'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $entry = new DnsEntry([
                    'name' => $args['name'],
                    'expire' => (int)$args['expire'],
                    'type' => $args['type'],
                    'content' => $args['content'],
                ]);
                $api->domainDns()->addDnsEntryToDomain($args['domainName'], $entry);
                return ['success' => true, 'message' => 'DNS entry added'];
            }
        );

        $this->register(
            'transip_domain_dns_update',
            'Update a single DNS entry for a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'name' => ['type' => 'string', 'description' => 'DNS entry name'],
                    'expire' => ['type' => 'integer', 'description' => 'TTL in seconds'],
                    'type' => ['type' => 'string', 'description' => 'Record type'],
                    'content' => ['type' => 'string', 'description' => 'Record content'],
                ],
                'required' => ['domainName', 'name', 'expire', 'type', 'content'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $entry = new DnsEntry([
                    'name' => $args['name'],
                    'expire' => (int)$args['expire'],
                    'type' => $args['type'],
                    'content' => $args['content'],
                ]);
                $api->domainDns()->updateEntry($args['domainName'], $entry);
                return ['success' => true, 'message' => 'DNS entry updated'];
            }
        );

        $this->register(
            'transip_domain_dns_replace_all',
            'Replace all DNS entries for a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'dnsEntries' => ['type' => 'array', 'description' => 'Array of DNS entries with name, expire, type, content'],
                ],
                'required' => ['domainName', 'dnsEntries'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $entries = array_map(fn ($e) => new DnsEntry($e), $args['dnsEntries']);
                $api->domainDns()->update($args['domainName'], $entries);
                return ['success' => true, 'message' => 'DNS entries replaced'];
            }
        );

        $this->register(
            'transip_domain_dns_remove',
            'Remove a DNS entry from a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'name' => ['type' => 'string', 'description' => 'DNS entry name'],
                    'expire' => ['type' => 'integer', 'description' => 'TTL'],
                    'type' => ['type' => 'string', 'description' => 'Record type'],
                    'content' => ['type' => 'string', 'description' => 'Record content'],
                ],
                'required' => ['domainName', 'name', 'expire', 'type', 'content'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $entry = new DnsEntry([
                    'name' => $args['name'],
                    'expire' => (int)$args['expire'],
                    'type' => $args['type'],
                    'content' => $args['content'],
                ]);
                $api->domainDns()->removeDnsEntry($args['domainName'], $entry);
                return ['success' => true, 'message' => 'DNS entry removed'];
            }
        );
    }

    // ==================== Domain DNSSEC ====================

    private function registerDomainDnsSecTools(): void
    {
        $this->register(
            'transip_domain_dnssec_get',
            'Get DNSSEC entries for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainDnsSec()->getByDomainName($args['domainName']));
            }
        );

        $this->register(
            'transip_domain_dnssec_update',
            'Update DNSSEC entries for a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'dnsSecEntries' => ['type' => 'array', 'description' => 'Array of DNSSEC entries'],
                ],
                'required' => ['domainName', 'dnsSecEntries'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $entries = array_map(fn ($e) => new DnsSecEntry($e), $args['dnsSecEntries']);
                $api->domainDnsSec()->update($args['domainName'], $entries);
                return ['success' => true, 'message' => 'DNSSEC entries updated'];
            }
        );
    }

    // ==================== Domain Nameservers ====================

    private function registerDomainNameserverTools(): void
    {
        $this->register(
            'transip_domain_nameservers_get',
            'Get nameservers for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainNameserver()->getByDomainName($args['domainName']));
            }
        );

        $this->register(
            'transip_domain_nameservers_update',
            'Update nameservers for a domain',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'nameservers' => ['type' => 'array', 'description' => 'Array of nameserver objects'],
                ],
                'required' => ['domainName', 'nameservers'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $nameservers = array_map(fn ($ns) => new Nameserver($ns), $args['nameservers']);
                $api->domainNameserver()->update($args['domainName'], $nameservers);
                return ['success' => true, 'message' => 'Nameservers updated'];
            }
        );
    }

    // ==================== Domain Contacts ====================

    private function registerDomainContactTools(): void
    {
        $this->register(
            'transip_domain_contacts_get',
            'Get WHOIS contacts for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainContact()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Domain Whois ====================

    private function registerDomainWhoisTools(): void
    {
        $this->register(
            'transip_domain_whois_get',
            'Get WHOIS information for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $api->domainWhois()->getByDomainName($args['domainName']);
            }
        );
    }

    // ==================== Domain Branding ====================

    private function registerDomainBrandingTools(): void
    {
        $this->register(
            'transip_domain_branding_get',
            'Get branding for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainBranding()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Domain SSL ====================

    private function registerDomainSslTools(): void
    {
        $this->register(
            'transip_domain_ssl_get',
            'Get SSL certificates for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainSsl()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Domain Actions ====================

    private function registerDomainActionTools(): void
    {
        $this->register(
            'transip_domain_action_get',
            'Get the current running action for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainAction()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Domain Auth Code ====================

    private function registerDomainAuthCodeTools(): void
    {
        $this->register(
            'transip_domain_auth_code_get',
            'Get the auth/transfer code for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $api->domainAuthCode()->getByDomainName($args['domainName']);
            }
        );
    }

    // ==================== Domain Availability ====================

    private function registerDomainAvailabilityTools(): void
    {
        $this->register(
            'transip_domain_availability_check',
            'Check domain name availability',
            [
                'properties' => [
                    'domainNames' => ['type' => 'array', 'items' => ['type' => 'string'], 'description' => 'Domain names to check'],
                ],
                'required' => ['domainNames'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainAvailability()->checkMultiple($args['domainNames']));
            }
        );
    }

    // ==================== Domain TLDs ====================

    private function registerDomainTldTools(): void
    {
        $this->register(
            'transip_domain_tlds_get_all',
            'Get all available TLDs',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->domainTlds()->getAll());
            }
        );
    }

    // ==================== Domain Whitelabel ====================

    private function registerDomainWhitelabelTools(): void
    {
        $this->register(
            'transip_domain_whitelabel_order',
            'Order a whitelabel domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->domainWhitelabel()->order($args['domainName']);
                return ['success' => true, 'message' => 'Whitelabel order placed'];
            }
        );
    }

    // ==================== Default Domain Contacts ====================

    private function registerDefaultDomainContactTools(): void
    {
        $this->register(
            'transip_default_domain_contacts_get',
            'Get default domain WHOIS contacts',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->defaultDomainContacts()->getAll());
            }
        );
    }

    // ==================== SSH Keys ====================

    private function registerSshKeyTools(): void
    {
        $this->register(
            'transip_ssh_keys_get_all',
            'Get all SSH keys',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->sshKey()->getAll());
            }
        );

        $this->register(
            'transip_ssh_key_get_by_id',
            'Get an SSH key by ID',
            [
                'properties' => ['sshKeyId' => ['type' => 'string', 'description' => 'SSH key ID']],
                'required' => ['sshKeyId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->sshKey()->getById($args['sshKeyId']));
            }
        );

        $this->register(
            'transip_ssh_key_create',
            'Add a new SSH key',
            [
                'properties' => [
                    'sshKey' => ['type' => 'string', 'description' => 'SSH public key content'],
                    'description' => ['type' => 'string', 'description' => 'Key description'],
                    'isDefault' => ['type' => 'boolean', 'description' => 'Set as default key (optional)'],
                ],
                'required' => ['sshKey', 'description'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->sshKey()->create($args['sshKey'], $args['description'], $args['isDefault'] ?? false);
                return ['success' => true, 'message' => 'SSH key created'];
            }
        );

        $this->register(
            'transip_ssh_key_update',
            'Update an SSH key description',
            [
                'properties' => [
                    'sshKeyId' => ['type' => 'integer', 'description' => 'SSH key ID'],
                    'description' => ['type' => 'string', 'description' => 'New description'],
                ],
                'required' => ['sshKeyId', 'description'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->sshKey()->update((int)$args['sshKeyId'], $args['description']);
                return ['success' => true, 'message' => 'SSH key updated'];
            }
        );

        $this->register(
            'transip_ssh_key_delete',
            'Delete an SSH key',
            [
                'properties' => ['sshKeyId' => ['type' => 'integer', 'description' => 'SSH key ID']],
                'required' => ['sshKeyId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->sshKey()->delete((int)$args['sshKeyId']);
                return ['success' => true, 'message' => 'SSH key deleted'];
            }
        );
    }

    // ==================== SSL Certificates ====================

    private function registerSslCertificateTools(): void
    {
        $this->register(
            'transip_ssl_certificates_get_all',
            'Get all SSL certificates',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->sslCertificate()->getAll());
            }
        );

        $this->register(
            'transip_ssl_certificate_get_by_id',
            'Get an SSL certificate by ID',
            [
                'properties' => ['certificateId' => ['type' => 'string', 'description' => 'Certificate ID']],
                'required' => ['certificateId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->sslCertificate()->getById($args['certificateId']));
            }
        );
    }

    // ==================== Invoices ====================

    private function registerInvoiceTools(): void
    {
        $this->register(
            'transip_invoices_get_all',
            'Get all invoices',
            [
                'properties' => [
                    'page' => ['type' => 'integer', 'description' => 'Page number (optional)'],
                    'itemsPerPage' => ['type' => 'integer', 'description' => 'Items per page (optional)'],
                ],
            ],
            function (TransipAPI $api, array $args): mixed {
                if (isset($args['page']) && isset($args['itemsPerPage'])) {
                    return $this->serializeResult($api->invoice()->getSelection((int)$args['page'], (int)$args['itemsPerPage']));
                }
                return $this->serializeResult($api->invoice()->getAll());
            }
        );

        $this->register(
            'transip_invoice_get_by_number',
            'Get an invoice by its number',
            [
                'properties' => ['invoiceNumber' => ['type' => 'string', 'description' => 'Invoice number']],
                'required' => ['invoiceNumber'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->invoice()->getByInvoiceNumber($args['invoiceNumber']));
            }
        );

        $this->register(
            'transip_invoice_items_get',
            'Get items for an invoice',
            [
                'properties' => ['invoiceNumber' => ['type' => 'string', 'description' => 'Invoice number']],
                'required' => ['invoiceNumber'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->invoiceItem()->getByInvoiceNumber($args['invoiceNumber']));
            }
        );

        $this->register(
            'transip_invoice_pdf_get',
            'Get the PDF for an invoice (base64 encoded)',
            [
                'properties' => ['invoiceNumber' => ['type' => 'string', 'description' => 'Invoice number']],
                'required' => ['invoiceNumber'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->invoicePdf()->getByInvoiceNumber($args['invoiceNumber']));
            }
        );
    }

    // ==================== Block Storage ====================

    private function registerBlockStorageTools(): void
    {
        $this->register(
            'transip_block_storages_get_all',
            'Get all block storages',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->blockStorages()->getAll());
            }
        );

        $this->register(
            'transip_block_storage_get_by_name',
            'Get a block storage by name',
            [
                'properties' => ['name' => ['type' => 'string', 'description' => 'Block storage name']],
                'required' => ['name'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->blockStorages()->getByName($args['name']));
            }
        );

        $this->register(
            'transip_block_storage_order',
            'Order a new block storage',
            [
                'properties' => [
                    'type' => ['type' => 'string', 'description' => 'Block storage type'],
                    'size' => ['type' => 'string', 'description' => 'Size in GB'],
                    'offsiteBackup' => ['type' => 'boolean', 'description' => 'Enable offsite backups (default: true)'],
                    'availabilityZone' => ['type' => 'string', 'description' => 'Availability zone (optional)'],
                    'vpsName' => ['type' => 'string', 'description' => 'VPS to attach to (optional)'],
                    'description' => ['type' => 'string', 'description' => 'Description (optional)'],
                ],
                'required' => ['type', 'size'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->blockStorages()->order(
                    $args['type'],
                    $args['size'],
                    $args['offsiteBackup'] ?? true,
                    $args['availabilityZone'] ?? '',
                    $args['vpsName'] ?? '',
                    $args['description'] ?? ''
                );
                return ['success' => true, 'message' => 'Block storage ordered'];
            }
        );

        $this->register(
            'transip_block_storage_cancel',
            'Cancel a block storage',
            [
                'properties' => [
                    'name' => ['type' => 'string', 'description' => 'Block storage name'],
                    'endTime' => ['type' => 'string', 'description' => 'End time: "end" or "immediately"'],
                ],
                'required' => ['name', 'endTime'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->blockStorages()->cancel($args['name'], $args['endTime']);
                return ['success' => true, 'message' => 'Block storage cancellation initiated'];
            }
        );
    }

    // ==================== Block Storage Backups ====================

    private function registerBlockStorageBackupTools(): void
    {
        $this->register(
            'transip_block_storage_backups_get',
            'Get backups for a block storage',
            [
                'properties' => ['blockStorageName' => ['type' => 'string', 'description' => 'Block storage name']],
                'required' => ['blockStorageName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->blockStorageBackups()->getByBlockStorageName($args['blockStorageName']));
            }
        );
    }

    // ==================== Block Storage Usage ====================

    private function registerBlockStorageUsageTools(): void
    {
        $this->register(
            'transip_block_storage_usage_get',
            'Get usage statistics for a block storage',
            [
                'properties' => ['blockStorageName' => ['type' => 'string', 'description' => 'Block storage name']],
                'required' => ['blockStorageName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->blockStorageUsage()->getByBlockStorageName($args['blockStorageName']));
            }
        );
    }

    // ==================== Private Networks ====================

    private function registerPrivateNetworkTools(): void
    {
        $this->register(
            'transip_private_networks_get_all',
            'Get all private networks',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->privateNetworks()->getAll());
            }
        );

        $this->register(
            'transip_private_network_get_by_name',
            'Get a private network by name',
            [
                'properties' => ['name' => ['type' => 'string', 'description' => 'Private network name']],
                'required' => ['name'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->privateNetworks()->getByName($args['name']));
            }
        );

        $this->register(
            'transip_private_network_order',
            'Order a new private network',
            [
                'properties' => [
                    'description' => ['type' => 'string', 'description' => 'Description (optional)'],
                ],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->privateNetworks()->order($args['description'] ?? '');
                return ['success' => true, 'message' => 'Private network ordered'];
            }
        );

        $this->register(
            'transip_private_network_attach_vps',
            'Attach a VPS to a private network',
            [
                'properties' => [
                    'privateNetworkName' => ['type' => 'string', 'description' => 'Private network name'],
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name to attach'],
                ],
                'required' => ['privateNetworkName', 'vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->privateNetworks()->attachVps($args['privateNetworkName'], $args['vpsName']);
                return ['success' => true, 'message' => 'VPS attached to private network'];
            }
        );

        $this->register(
            'transip_private_network_detach_vps',
            'Detach a VPS from a private network',
            [
                'properties' => [
                    'privateNetworkName' => ['type' => 'string', 'description' => 'Private network name'],
                    'vpsName' => ['type' => 'string', 'description' => 'VPS name to detach'],
                ],
                'required' => ['privateNetworkName', 'vpsName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->privateNetworks()->detachVps($args['privateNetworkName'], $args['vpsName']);
                return ['success' => true, 'message' => 'VPS detached from private network'];
            }
        );

        $this->register(
            'transip_private_network_cancel',
            'Cancel a private network',
            [
                'properties' => [
                    'name' => ['type' => 'string', 'description' => 'Private network name'],
                    'endTime' => ['type' => 'string', 'description' => 'End time: "end" or "immediately"'],
                ],
                'required' => ['name', 'endTime'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->privateNetworks()->cancel($args['name'], $args['endTime']);
                return ['success' => true, 'message' => 'Private network cancellation initiated'];
            }
        );
    }

    // ==================== HA-IP ====================

    private function registerHaipTools(): void
    {
        $this->register(
            'transip_haips_get_all',
            'Get all HA-IPs',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->haip()->getAll());
            }
        );

        $this->register(
            'transip_haip_get_by_name',
            'Get a HA-IP by name',
            [
                'properties' => ['name' => ['type' => 'string', 'description' => 'HA-IP name']],
                'required' => ['name'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->haip()->getByName($args['name']));
            }
        );

        $this->register(
            'transip_haip_order',
            'Order a new HA-IP',
            [
                'properties' => [
                    'productName' => ['type' => 'string', 'description' => 'HA-IP product name'],
                    'description' => ['type' => 'string', 'description' => 'Description (optional)'],
                ],
                'required' => ['productName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->haip()->order($args['productName'], $args['description'] ?? null);
                return ['success' => true, 'message' => 'HA-IP ordered'];
            }
        );

        $this->register(
            'transip_haip_cancel',
            'Cancel a HA-IP',
            [
                'properties' => [
                    'name' => ['type' => 'string', 'description' => 'HA-IP name'],
                    'endTime' => ['type' => 'string', 'description' => 'End time: "end" or "immediately"'],
                ],
                'required' => ['name', 'endTime'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->haip()->cancel($args['name'], $args['endTime']);
                return ['success' => true, 'message' => 'HA-IP cancellation initiated'];
            }
        );
    }

    // ==================== HA-IP Certificates ====================

    private function registerHaipCertificateTools(): void
    {
        $this->register(
            'transip_haip_certificates_get',
            'Get certificates for a HA-IP',
            [
                'properties' => ['haipName' => ['type' => 'string', 'description' => 'HA-IP name']],
                'required' => ['haipName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->haipCertificates()->getByHaipName($args['haipName']));
            }
        );
    }

    // ==================== HA-IP IP Addresses ====================

    private function registerHaipIpAddressTools(): void
    {
        $this->register(
            'transip_haip_ip_addresses_get',
            'Get IP addresses for a HA-IP',
            [
                'properties' => ['haipName' => ['type' => 'string', 'description' => 'HA-IP name']],
                'required' => ['haipName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->haipIpAddresses()->getByHaipName($args['haipName']));
            }
        );
    }

    // ==================== HA-IP Port Configurations ====================

    private function registerHaipPortConfigurationTools(): void
    {
        $this->register(
            'transip_haip_port_configurations_get',
            'Get port configurations for a HA-IP',
            [
                'properties' => ['haipName' => ['type' => 'string', 'description' => 'HA-IP name']],
                'required' => ['haipName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->haipPortConfigurations()->getByHaipName($args['haipName']));
            }
        );
    }

    // ==================== HA-IP Status Reports ====================

    private function registerHaipStatusReportTools(): void
    {
        $this->register(
            'transip_haip_status_reports_get',
            'Get status reports for a HA-IP',
            [
                'properties' => ['haipName' => ['type' => 'string', 'description' => 'HA-IP name']],
                'required' => ['haipName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->haipStatusReports()->getByHaipName($args['haipName']));
            }
        );
    }

    // ==================== Colocation ====================

    private function registerColocationTools(): void
    {
        $this->register(
            'transip_colocations_get_all',
            'Get all colocations',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->colocation()->getAll());
            }
        );

        $this->register(
            'transip_colocation_get_by_name',
            'Get a colocation by name',
            [
                'properties' => ['name' => ['type' => 'string', 'description' => 'Colocation name']],
                'required' => ['name'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->colocation()->getByName($args['name']));
            }
        );

        $this->register(
            'transip_colocation_ip_addresses_get',
            'Get IP addresses for a colocation',
            [
                'properties' => ['colocationName' => ['type' => 'string', 'description' => 'Colocation name']],
                'required' => ['colocationName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->colocationIpAddress()->getByColocationName($args['colocationName']));
            }
        );
    }

    // ==================== Mail Service ====================

    private function registerMailServiceTools(): void
    {
        $this->register(
            'transip_mail_service_get',
            'Get mail service information for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->mailService()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Mailboxes ====================

    private function registerMailboxTools(): void
    {
        $this->register(
            'transip_mailboxes_get',
            'Get all mailboxes for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->mailboxes()->getByDomainName($args['domainName']));
            }
        );

        $this->register(
            'transip_mailbox_create',
            'Create a new mailbox',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'localPart' => ['type' => 'string', 'description' => 'Local part of email (before @)'],
                    'maxDiskUsage' => ['type' => 'integer', 'description' => 'Max disk usage in MB'],
                    'password' => ['type' => 'string', 'description' => 'Mailbox password'],
                    'forwardTo' => ['type' => 'string', 'description' => 'Forward address (optional)'],
                ],
                'required' => ['domainName', 'localPart', 'maxDiskUsage', 'password'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->mailboxes()->create(
                    $args['domainName'],
                    $args['localPart'],
                    (int)$args['maxDiskUsage'],
                    $args['password'],
                    $args['forwardTo'] ?? ''
                );
                return ['success' => true, 'message' => 'Mailbox created'];
            }
        );

        $this->register(
            'transip_mailbox_delete',
            'Delete a mailbox',
            [
                'properties' => [
                    'domainName' => ['type' => 'string', 'description' => 'Domain name'],
                    'identifier' => ['type' => 'string', 'description' => 'Mailbox identifier'],
                ],
                'required' => ['domainName', 'identifier'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->mailboxes()->delete($args['identifier'], $args['domainName']);
                return ['success' => true, 'message' => 'Mailbox deleted'];
            }
        );
    }

    // ==================== Mail Forwards ====================

    private function registerMailForwardTools(): void
    {
        $this->register(
            'transip_mail_forwards_get',
            'Get all mail forwards for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->mailForwards()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Mail Lists ====================

    private function registerMailListTools(): void
    {
        $this->register(
            'transip_mail_lists_get',
            'Get all mailing lists for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->mailLists()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Mail Packages ====================

    private function registerMailPackageTools(): void
    {
        $this->register(
            'transip_mail_packages_get',
            'Get all mail packages for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->mailPackages()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Mail Addons ====================

    private function registerMailAddonTools(): void
    {
        $this->register(
            'transip_mail_addons_get',
            'Get all mail addons for a domain',
            [
                'properties' => ['domainName' => ['type' => 'string', 'description' => 'Domain name']],
                'required' => ['domainName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->mailAddons()->getByDomainName($args['domainName']));
            }
        );
    }

    // ==================== Kubernetes Clusters ====================

    private function registerKubernetesClusterTools(): void
    {
        $this->register(
            'transip_kubernetes_clusters_get_all',
            'Get all Kubernetes clusters',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesClusters()->getAll());
            }
        );

        $this->register(
            'transip_kubernetes_cluster_get_by_name',
            'Get a Kubernetes cluster by name',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesClusters()->getByName($args['clusterName']));
            }
        );

        $this->register(
            'transip_kubernetes_cluster_create',
            'Create a new Kubernetes cluster',
            [
                'properties' => [
                    'kubernetesVersion' => ['type' => 'string', 'description' => 'Kubernetes version (optional)'],
                    'description' => ['type' => 'string', 'description' => 'Description (optional)'],
                    'nodeSpec' => ['type' => 'string', 'description' => 'Node specification (optional)'],
                    'desiredNodeCount' => ['type' => 'integer', 'description' => 'Desired number of nodes (optional)'],
                    'availabilityZone' => ['type' => 'string', 'description' => 'Availability zone (optional)'],
                ],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->kubernetesClusters()->create(
                    $args['kubernetesVersion'] ?? null,
                    $args['description'] ?? '',
                    $args['nodeSpec'] ?? null,
                    isset($args['desiredNodeCount']) ? (int)$args['desiredNodeCount'] : null,
                    $args['availabilityZone'] ?? null
                );
                return ['success' => true, 'message' => 'Kubernetes cluster creation initiated'];
            }
        );

        $this->register(
            'transip_kubernetes_cluster_upgrade',
            'Upgrade a Kubernetes cluster version',
            [
                'properties' => [
                    'clusterName' => ['type' => 'string', 'description' => 'Cluster name'],
                    'version' => ['type' => 'string', 'description' => 'Target Kubernetes version'],
                ],
                'required' => ['clusterName', 'version'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->kubernetesClusters()->upgrade($args['clusterName'], $args['version']);
                return ['success' => true, 'message' => 'Cluster upgrade initiated'];
            }
        );

        $this->register(
            'transip_kubernetes_cluster_reset',
            'Reset a Kubernetes cluster',
            [
                'properties' => [
                    'clusterName' => ['type' => 'string', 'description' => 'Cluster name'],
                    'confirmation' => ['type' => 'string', 'description' => 'Confirmation string'],
                ],
                'required' => ['clusterName', 'confirmation'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->kubernetesClusters()->reset($args['clusterName'], $args['confirmation']);
                return ['success' => true, 'message' => 'Cluster reset initiated'];
            }
        );

        $this->register(
            'transip_kubernetes_cluster_remove',
            'Remove a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                $api->kubernetesClusters()->remove($args['clusterName']);
                return ['success' => true, 'message' => 'Cluster removal initiated'];
            }
        );
    }

    // ==================== Kubernetes Nodes ====================

    private function registerKubernetesNodeTools(): void
    {
        $this->register(
            'transip_kubernetes_nodes_get',
            'Get all nodes for a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesNodes()->getByClusterName($args['clusterName']));
            }
        );
    }

    // ==================== Kubernetes Node Pools ====================

    private function registerKubernetesNodePoolTools(): void
    {
        $this->register(
            'transip_kubernetes_node_pools_get',
            'Get all node pools for a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesNodePools()->getByClusterName($args['clusterName']));
            }
        );
    }

    // ==================== Kubernetes Block Storages ====================

    private function registerKubernetesBlockStorageTools(): void
    {
        $this->register(
            'transip_kubernetes_block_storages_get',
            'Get all block storages for a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesBlockStorages()->getByClusterName($args['clusterName']));
            }
        );
    }

    // ==================== Kubernetes Events ====================

    private function registerKubernetesEventTools(): void
    {
        $this->register(
            'transip_kubernetes_events_get',
            'Get events for a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesEvents()->getByClusterName($args['clusterName']));
            }
        );
    }

    // ==================== Kubernetes Load Balancers ====================

    private function registerKubernetesLoadBalancerTools(): void
    {
        $this->register(
            'transip_kubernetes_load_balancers_get',
            'Get load balancers for a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesLoadBalancers()->getByClusterName($args['clusterName']));
            }
        );
    }

    // ==================== Kubernetes Products ====================

    private function registerKubernetesProductTools(): void
    {
        $this->register(
            'transip_kubernetes_products_get_all',
            'Get all available Kubernetes products',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesProducts()->getAll());
            }
        );
    }

    // ==================== Kubernetes Releases ====================

    private function registerKubernetesReleaseTools(): void
    {
        $this->register(
            'transip_kubernetes_releases_get_all',
            'Get all available Kubernetes releases',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesReleases()->getAll());
            }
        );
    }

    // ==================== Kubernetes Labels ====================

    private function registerKubernetesLabelTools(): void
    {
        $this->register(
            'transip_kubernetes_labels_get',
            'Get labels for a node pool in a Kubernetes cluster',
            [
                'properties' => [
                    'clusterName' => ['type' => 'string', 'description' => 'Cluster name'],
                    'nodePoolUuid' => ['type' => 'string', 'description' => 'Node pool UUID'],
                ],
                'required' => ['clusterName', 'nodePoolUuid'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesLabels()->getByClusterNameNodePoolUuid($args['clusterName'], $args['nodePoolUuid']));
            }
        );
    }

    // ==================== Kubernetes Taints ====================

    private function registerKubernetesTaintTools(): void
    {
        $this->register(
            'transip_kubernetes_taints_get',
            'Get taints for a node pool in a Kubernetes cluster',
            [
                'properties' => [
                    'clusterName' => ['type' => 'string', 'description' => 'Cluster name'],
                    'nodePoolUuid' => ['type' => 'string', 'description' => 'Node pool UUID'],
                ],
                'required' => ['clusterName', 'nodePoolUuid'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesTaints()->getByClusterNameNodePoolUuid($args['clusterName'], $args['nodePoolUuid']));
            }
        );
    }

    // ==================== Kubernetes KubeConfig ====================

    private function registerKubernetesKubeConfigTools(): void
    {
        $this->register(
            'transip_kubernetes_kubeconfig_get',
            'Get the kubeconfig for a Kubernetes cluster',
            [
                'properties' => ['clusterName' => ['type' => 'string', 'description' => 'Cluster name']],
                'required' => ['clusterName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->kubernetesKubeConfig()->getByClusterName($args['clusterName']));
            }
        );
    }

    // ==================== OpenStack ====================

    private function registerOpenStackTools(): void
    {
        $this->register(
            'transip_openstack_projects_get_all',
            'Get all OpenStack projects',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->openStackProjects()->getAll());
            }
        );

        $this->register(
            'transip_openstack_project_get_by_id',
            'Get an OpenStack project by ID',
            [
                'properties' => ['projectId' => ['type' => 'string', 'description' => 'Project ID']],
                'required' => ['projectId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->openStackProjects()->getByProjectId($args['projectId']));
            }
        );

        $this->register(
            'transip_openstack_users_get_all',
            'Get all OpenStack users',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->openStackUsers()->getAll());
            }
        );

        $this->register(
            'transip_openstack_project_users_get',
            'Get users for an OpenStack project',
            [
                'properties' => ['projectId' => ['type' => 'string', 'description' => 'Project ID']],
                'required' => ['projectId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->openStackProjectUsers()->getByProjectId($args['projectId']));
            }
        );

        $this->register(
            'transip_openstack_token_get',
            'Get an OpenStack token for a project',
            [
                'properties' => ['projectId' => ['type' => 'string', 'description' => 'Project ID']],
                'required' => ['projectId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->openStackTokens()->getByProjectId($args['projectId']));
            }
        );
    }

    // ==================== Traffic Pool ====================

    private function registerTrafficPoolTools(): void
    {
        $this->register(
            'transip_traffic_pool_get',
            'Get traffic pool information',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->trafficPool()->getAll());
            }
        );
    }

    // ==================== Actions ====================

    private function registerActionTools(): void
    {
        $this->register(
            'transip_actions_get_all',
            'Get all running actions',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->actions()->getAll());
            }
        );

        $this->register(
            'transip_action_get_by_id',
            'Get a specific action by ID',
            [
                'properties' => ['actionId' => ['type' => 'string', 'description' => 'Action ID']],
                'required' => ['actionId'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->actions()->getById($args['actionId']));
            }
        );
    }

    // ==================== Acronis ====================

    private function registerAcronisTools(): void
    {
        $this->register(
            'transip_acronis_tenants_get_all',
            'Get all Acronis tenants',
            ['properties' => []],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->acronisTenants()->getAll());
            }
        );

        $this->register(
            'transip_acronis_tenant_get_by_service',
            'Get an Acronis tenant by service name',
            [
                'properties' => ['serviceName' => ['type' => 'string', 'description' => 'Service name (VPS name)']],
                'required' => ['serviceName'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->acronisTenants()->getByServiceName($args['serviceName']));
            }
        );
    }

    // ==================== Contact Key ====================

    private function registerContactKeyTools(): void
    {
        $this->register(
            'transip_contact_key_verify',
            'Verify a contact key',
            [
                'properties' => ['contactKey' => ['type' => 'string', 'description' => 'Contact key to verify']],
                'required' => ['contactKey'],
            ],
            function (TransipAPI $api, array $args): mixed {
                return $this->serializeResult($api->contactKey()->verify($args['contactKey']));
            }
        );
    }
}
