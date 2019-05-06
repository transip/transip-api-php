<?php

require_once('ApiSettings.php');
require_once('Product.php');
require_once('PrivateNetwork.php');
require_once('Vps.php');
require_once('Snapshot.php');
require_once('VpsBackup.php');
require_once('OperatingSystem.php');
require_once('AvailabilityZone.php');

/**
 * This is the API endpoint for the VpsService
 *
 * @package Transip
 * @class VpsService
 * @author TransIP (support@transip.nl)
 */
class Transip_VpsService
{
	// These fields are SOAP related
	/** The SOAP service that corresponds with this class. */
	const SERVICE = 'VpsService';
	/** The API version. */
	const API_VERSION = '5.13';
	/** @var SoapClient  The SoapClient used to perform the SOAP calls. */
	protected static $_soapClient = null;

	/**
	 * Gets the singleton SoapClient which is used to connect to the TransIP Api.
	 *
	 * @param  mixed       $parameters  Parameters.
	 * @return SoapClient               The SoapClient object to which we can connect to the TransIP API
	 */
	public static function _getSoapClient($parameters = array())
	{
		$endpoint = Transip_ApiSettings::$endpoint;

		if(self::$_soapClient === null)
		{
			$extensions = get_loaded_extensions();
			$errors     = array();
			if(!class_exists('SoapClient') || !in_array('soap', $extensions))
			{
				$errors[] = 'The PHP SOAP extension doesn\'t seem to be installed. You need to install the PHP SOAP extension. (See: http://www.php.net/manual/en/book.soap.php)';
			}
			if(!in_array('openssl', $extensions))
			{
				$errors[] = 'The PHP OpenSSL extension doesn\'t seem to be installed. You need to install PHP with the OpenSSL extension. (See: http://www.php.net/manual/en/book.openssl.php)';
			}
			if(!empty($errors)) die('<p>' . implode("</p>\n<p>", $errors) . '</p>');

			$classMap = array(
				'Product' => 'Transip_Product',
				'PrivateNetwork' => 'Transip_PrivateNetwork',
				'Vps' => 'Transip_Vps',
				'Snapshot' => 'Transip_Snapshot',
				'VpsBackup' => 'Transip_VpsBackup',
				'OperatingSystem' => 'Transip_OperatingSystem',
				'AvailabilityZone' => 'Transip_AvailabilityZone',
			);

			$options = array(
				'classmap' => $classMap,
				'encoding' => 'utf-8', // lets support unicode
				'features' => SOAP_SINGLE_ELEMENT_ARRAYS, // see http://bugs.php.net/bug.php?id=43338
				'trace'    => false, // can be used for debugging
			);

			$wsdlUri  = "https://{$endpoint}/wsdl/?service=" . self::SERVICE;
			try
			{
				self::$_soapClient = new SoapClient($wsdlUri, $options);
			}
			catch(SoapFault $sf)
			{
				throw new Exception("Unable to connect to endpoint '{$endpoint}'");
			}
			self::$_soapClient->__setCookie('login', Transip_ApiSettings::$login);
			self::$_soapClient->__setCookie('mode', Transip_ApiSettings::$mode);
		}

		$timestamp = time();
		$nonce     = uniqid('', true);

		self::$_soapClient->__setCookie('timestamp', $timestamp);
		self::$_soapClient->__setCookie('nonce', $nonce);
		self::$_soapClient->__setCookie('clientVersion', self::API_VERSION);
		self::$_soapClient->__setCookie('signature', self::_urlencode(self::_sign(array_merge($parameters, array(
			'__service'   => self::SERVICE,
			'__hostname'  => $endpoint,
			'__timestamp' => $timestamp,
			'__nonce'     => $nonce
		)))));

		return self::$_soapClient;
	}

	/**
	 * Calculates the hash to sign our request with based on the given parameters.
	 *
	 * @param  mixed   $parameters  The parameters to sign.
	 * @return string               Base64 encoded signing hash.
	 */
	protected static function _sign($parameters)
	{
		// Fixup our private key, copy-pasting the key might lead to whitespace faults
		if(!preg_match('/-----BEGIN (RSA )?PRIVATE KEY-----(.*)-----END (RSA )?PRIVATE KEY-----/si', Transip_ApiSettings::$privateKey, $matches))
			die('<p>Could not find your private key, please supply your private key in the ApiSettings file. You can request a new private key in your TransIP Controlpanel.</p>');

		$key = $matches[2];
		$key = preg_replace('/\s*/s', '', $key);
		$key = chunk_split($key, 64, "\n");

		$key = "-----BEGIN PRIVATE KEY-----\n" . $key . "-----END PRIVATE KEY-----";

		$digest = self::_sha512Asn1(self::_encodeParameters($parameters));
		if(!@openssl_private_encrypt($digest, $signature, $key))
			die('<p>Could not sign your request, please supply your private key in the ApiSettings file. You can request a new private key in your TransIP Controlpanel.</p>');

		return base64_encode($signature);
	}

	/**
	 * Creates a digest of the given data, with an asn1 header.
	 *
	 * @param  string  $data  The data to create a digest of.
	 * @return string         The digest of the data, with asn1 header.
	 */
	protected static function _sha512Asn1($data)
	{
		$digest = hash('sha512', $data, true);

		// this ASN1 header is sha512 specific
		$asn1  = chr(0x30).chr(0x51);
		$asn1 .= chr(0x30).chr(0x0d);
		$asn1 .= chr(0x06).chr(0x09);
		$asn1 .= chr(0x60).chr(0x86).chr(0x48).chr(0x01).chr(0x65);
		$asn1 .= chr(0x03).chr(0x04);
		$asn1 .= chr(0x02).chr(0x03);
		$asn1 .= chr(0x05).chr(0x00);
		$asn1 .= chr(0x04).chr(0x40);
		$asn1 .= $digest;

		return $asn1;
	}

	/**
	 * Encodes the given paramaters into a url encoded string based upon RFC 3986.
	 *
	 * @param  mixed   $parameters  The parameters to encode.
	 * @param  string  $keyPrefix   Key prefix.
	 * @return string               The given parameters encoded according to RFC 3986.
	 */
	protected static function _encodeParameters($parameters, $keyPrefix = null)
	{
		if(!is_array($parameters) && !is_object($parameters))
			return self::_urlencode($parameters);

		$encodedData = array();

		foreach($parameters as $key => $value)
		{
			$encodedKey = is_null($keyPrefix)
				? self::_urlencode($key)
				: $keyPrefix . '[' . self::_urlencode($key) . ']';

			if(is_array($value) || is_object($value))
			{
				$encodedData[] = self::_encodeParameters($value, $encodedKey);
			}
			else
			{
				$encodedData[] = $encodedKey . '=' . self::_urlencode($value);
			}
		}

		return implode('&', $encodedData);
	}

	/**
	 * Our own function to encode a string according to RFC 3986 since.
	 * PHP < 5.3.0 encodes the ~ character which is not allowed.
	 *
	 * @param string $string The string to encode.
	 * @return string The encoded string according to RFC 3986.
	 */
	protected static function _urlencode($string)
	{
		$string = trim($string);
		$string = rawurlencode($string);
		return str_replace('%7E', '~', $string);
	}

	const CANCELLATIONTIME_END = 'end';
	const CANCELLATIONTIME_IMMEDIATELY = 'immediately';
	const TRACK_ENDPOINT_NAME = 'VPS';

	/**
	 * Get available VPS products
	 *
	 * @return Transip_Product[] List of available VPS Products
	 */
	public static function getAvailableProducts()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAvailableProducts')))->getAvailableProducts();
	}

	/**
	 * Get available VPS addons
	 *
	 * @return Transip_Product[] List of available VPS Products
	 */
	public static function getAvailableAddons()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAvailableAddons')))->getAvailableAddons();
	}

	/**
	 * Get all the Active Addons for Vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @return Transip_Product[] List of available VPS Products
	 */
	public static function getActiveAddonsForVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getActiveAddonsForVps')))->getActiveAddonsForVps($vpsName);
	}

	/**
	 * Get available VPS upgrades for a specific Vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @return Transip_Product[] List of available VPS Products
	 */
	public static function getAvailableUpgrades($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getAvailableUpgrades')))->getAvailableUpgrades($vpsName);
	}

	/**
	 * Get available Addons for Vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @return Transip_Product[] List of available VPS Products
	 */
	public static function getAvailableAddonsForVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getAvailableAddonsForVps')))->getAvailableAddonsForVps($vpsName);
	}

	/**
	 * Get cancellable addons for specific Vps
	 *
	 * @param string $vpsName The name of the Vps
	 * @return Transip_Product[] List of cancellable addons for this Vps
	 */
	public static function getCancellableAddonsForVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getCancellableAddonsForVps')))->getCancellableAddonsForVps($vpsName);
	}

	/**
	 * Order a VPS with optional Addons
	 *
	 * @param string $productName Name of the product
	 * @param string[] $addons array with additional addons
	 * @param string $operatingSystemName The name of the operatingSystem to install
	 * @param string $hostname The name for the host
	 * @throws Exception
	 */
	public static function orderVps($productName, $addons, $operatingSystemName, $hostname)
	{
		return self::_getSoapClient(array_merge(array($productName, $addons, $operatingSystemName, $hostname), array('__method' => 'orderVps')))->orderVps($productName, $addons, $operatingSystemName, $hostname);
	}

	/**
	 * Order a VPS with optional Addons
	 *
	 * @param string $productName Name of the product
	 * @param string[] $addons array with additional addons
	 * @param string $operatingSystemName The name of the operatingSystem to install
	 * @param string $hostname The name for the host
	 * @param string $availabilityZone The availability zone the vps should be created in
	 * @throws Exception
	 */
	public static function orderVpsInAvailabilityZone($productName, $addons, $operatingSystemName, $hostname, $availabilityZone)
	{
		return self::_getSoapClient(array_merge(array($productName, $addons, $operatingSystemName, $hostname, $availabilityZone), array('__method' => 'orderVpsInAvailabilityZone')))->orderVpsInAvailabilityZone($productName, $addons, $operatingSystemName, $hostname, $availabilityZone);
	}

	/**
	 * Clone a VPS
	 *
	 * @param string $vpsName The vps name
	 * @throws Exception
	 */
	public static function cloneVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'cloneVps')))->cloneVps($vpsName);
	}

	/**
	 * Clone a VPS
	 *
	 * @param string $vpsName The vps name
	 * @param string $availabilityZone The availability zone the clone should be created in.
	 * @throws Exception
	 */
	public static function cloneVpsToAvailabilityZone($vpsName, $availabilityZone)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $availabilityZone), array('__method' => 'cloneVpsToAvailabilityZone')))->cloneVpsToAvailabilityZone($vpsName, $availabilityZone);
	}

	/**
	 * Order addons to a VPS
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string[] $addons Array with Addons
	 * @throws ApiException on error
	 */
	public static function orderAddon($vpsName, $addons)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $addons), array('__method' => 'orderAddon')))->orderAddon($vpsName, $addons);
	}

	/**
	 * Order a private Network
	 *
	 * @throws ApiException on error
	 */
	public static function orderPrivateNetwork()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'orderPrivateNetwork')))->orderPrivateNetwork();
	}

	/**
	 * upgrade a Vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string $upgradeToProductName The name of the product to upgrade to
	 * @throws ApiException on error
	 */
	public static function upgradeVps($vpsName, $upgradeToProductName)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $upgradeToProductName), array('__method' => 'upgradeVps')))->upgradeVps($vpsName, $upgradeToProductName);
	}

	/**
	 * Cancel a Vps
	 *
	 * @param string $vpsName The vps to cancel
	 * @param string $endTime The time to cancel the vps (VpsService::CANCELLATIONTIME_END (end of contract)
	 * @throws ApiException on error
	 */
	public static function cancelVps($vpsName, $endTime)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $endTime), array('__method' => 'cancelVps')))->cancelVps($vpsName, $endTime);
	}

	/**
	 * Cancel a Vps Addon
	 *
	 * @param string $vpsName The vps to cancel
	 * @param string $addonName name of the addon
	 * @throws ApiException on error
	 */
	public static function cancelAddon($vpsName, $addonName)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $addonName), array('__method' => 'cancelAddon')))->cancelAddon($vpsName, $addonName);
	}

	/**
	 * Cancel a PrivateNetwork
	 *
	 * @param string $privateNetworkName the name of the private network to cancel
	 * @param string $endTime The time to cancel the vps (VpsService::CANCELLATIONTIME_END (end of contract)
	 * @throws ApiException on error
	 */
	public static function cancelPrivateNetwork($privateNetworkName, $endTime)
	{
		return self::_getSoapClient(array_merge(array($privateNetworkName, $endTime), array('__method' => 'cancelPrivateNetwork')))->cancelPrivateNetwork($privateNetworkName, $endTime);
	}

	/**
	 * Get Private networks for a specific vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @return Transip_PrivateNetwork[] $privateNetworks Array of PrivateNetwork objects
	 */
	public static function getPrivateNetworksByVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getPrivateNetworksByVps')))->getPrivateNetworksByVps($vpsName);
	}

	/**
	 * Get all Private networks in your account
	 *
	 * @return Transip_PrivateNetwork[] $privateNetworks Array of PrivateNetwork objects
	 */
	public static function getAllPrivateNetworks()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAllPrivateNetworks')))->getAllPrivateNetworks();
	}

	/**
	 * Add VPS to a private Network
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string $privateNetworkName The name of the privateNetwork to add to
	 */
	public static function addVpsToPrivateNetwork($vpsName, $privateNetworkName)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $privateNetworkName), array('__method' => 'addVpsToPrivateNetwork')))->addVpsToPrivateNetwork($vpsName, $privateNetworkName);
	}

	/**
	 * Remove VPS from a private Network
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string $privateNetworkName The name of the private Network
	 */
	public static function removeVpsFromPrivateNetwork($vpsName, $privateNetworkName)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $privateNetworkName), array('__method' => 'removeVpsFromPrivateNetwork')))->removeVpsFromPrivateNetwork($vpsName, $privateNetworkName);
	}

	/**
	 * Get Traffic information by vpsName for this contractPeriod
	 *
	 * @param string $vpsName The name of the VPS
	 * @throws ApiException on error
	 * @return array The traffic information for this VPS
	 */
	public static function getTrafficInformationForVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getTrafficInformationForVps')))->getTrafficInformationForVps($vpsName);
	}

	/**
	 * Get PooledTraffic information for the account
	 *
	 * @return array 
	 */
	public static function getPooledTrafficInformation()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getPooledTrafficInformation')))->getPooledTrafficInformation();
	}

	/**
	 * Start a Vps
	 *
	 * @param string $vpsName The vps name
	 * @throws ApiException on error
	 */
	public static function start($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'start')))->start($vpsName);
	}

	/**
	 * Stop a Vps
	 *
	 * @param string $vpsName The vps name
	 * @throws ApiException on error
	 */
	public static function stop($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'stop')))->stop($vpsName);
	}

	/**
	 * Reset a Vps
	 *
	 * @param string $vpsName The vps name
	 * @throws ApiException on error
	 */
	public static function reset($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'reset')))->reset($vpsName);
	}

	/**
	 * Create a snapshot
	 *
	 * @param string $vpsName The vps name
	 * @param string $description The snapshot description
	 * @throws ApiException on error
	 */
	public static function createSnapshot($vpsName, $description)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $description), array('__method' => 'createSnapshot')))->createSnapshot($vpsName, $description);
	}

	/**
	 * Revert a snapshot
	 *
	 * @param string $vpsName The vps name
	 * @param string $snapshotName The snapshot name
	 * @throws ApiException on error
	 */
	public static function revertSnapshot($vpsName, $snapshotName)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $snapshotName), array('__method' => 'revertSnapshot')))->revertSnapshot($vpsName, $snapshotName);
	}

	/**
	 * Revert a snapshot to another VPS
	 *
	 * @param string $sourceVpsName The name of the VPS where the snapshot is made
	 * @param string $snapshotName The snapshot name
	 * @param string $destinationVpsName The name of the VPS where the snapshot should be reverted to
	 * @throws ApiException on error
	 */
	public static function revertSnapshotToOtherVps($sourceVpsName, $snapshotName, $destinationVpsName)
	{
		return self::_getSoapClient(array_merge(array($sourceVpsName, $snapshotName, $destinationVpsName), array('__method' => 'revertSnapshotToOtherVps')))->revertSnapshotToOtherVps($sourceVpsName, $snapshotName, $destinationVpsName);
	}

	/**
	 * Remove a snapshot
	 *
	 * @param string $vpsName The vps name
	 * @param string $snapshotName The snapshot name
	 * @throws ApiException on error
	 */
	public static function removeSnapshot($vpsName, $snapshotName)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $snapshotName), array('__method' => 'removeSnapshot')))->removeSnapshot($vpsName, $snapshotName);
	}

	/**
	 * Revert a vps backup
	 *
	 * @param string $vpsName The vps name
	 * @param int $vpsBackupId The backup id
	 * @throws ApiException on error
	 */
	public static function revertVpsBackup($vpsName, $vpsBackupId)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $vpsBackupId), array('__method' => 'revertVpsBackup')))->revertVpsBackup($vpsName, $vpsBackupId);
	}

	/**
	 * Get a Vps by name
	 *
	 * @param string $vpsName The vps name
	 * @return Transip_Vps $vps    The vps objects
	 */
	public static function getVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getVps')))->getVps($vpsName);
	}

	/**
	 * Get all Vpses
	 *
	 * @return Transip_Vps[] Array of Vps objects
	 */
	public static function getVpses()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getVpses')))->getVpses();
	}

	/**
	 * Get all Snapshots for a vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @return Transip_Snapshot[] $snapshotArray Array of snapshot objects
	 */
	public static function getSnapshotsByVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getSnapshotsByVps')))->getSnapshotsByVps($vpsName);
	}

	/**
	 * Get all VpsBackups for a vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @return Transip_VpsBackup[] $vpsBackupArray Array of snapshot objects
	 */
	public static function getVpsBackupsByVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getVpsBackupsByVps')))->getVpsBackupsByVps($vpsName);
	}

	/**
	 * Get all operating systems
	 *
	 * @return Transip_OperatingSystem[] Array of OperatingSystem objects
	 */
	public static function getOperatingSystems()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getOperatingSystems')))->getOperatingSystems();
	}

	/**
	 * Install an operating system on a vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string $operatingSystemName The name of the operating to install
	 * @param string $hostname preinstallable Only
	 */
	public static function installOperatingSystem($vpsName, $operatingSystemName, $hostname)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $operatingSystemName, $hostname), array('__method' => 'installOperatingSystem')))->installOperatingSystem($vpsName, $operatingSystemName, $hostname);
	}

	/**
	 * Install an operating system on a vps with a unattended installfile
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string $operatingSystemName The name of the operating to install
	 * @param string $base64InstallText base64_encoded preseed/kickstart text
	 * @throws ApiException
	 */
	public static function installOperatingSystemUnattended($vpsName, $operatingSystemName, $base64InstallText)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $operatingSystemName, $base64InstallText), array('__method' => 'installOperatingSystemUnattended')))->installOperatingSystemUnattended($vpsName, $operatingSystemName, $base64InstallText);
	}

	/**
	 * Get Ips for a specific Vps
	 *
	 * @param string $vpsName The name of the Vps
	 * @return string[] $ipAddresses Array of ipAddresses
	 */
	public static function getIpsForVps($vpsName)
	{
		return self::_getSoapClient(array_merge(array($vpsName), array('__method' => 'getIpsForVps')))->getIpsForVps($vpsName);
	}

	/**
	 * Get All ips
	 *
	 * @return string[] $ipAddresses Array of ipAddresses
	 */
	public static function getAllIps()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAllIps')))->getAllIps();
	}

	/**
	 * Add Ipv6 Address to Vps
	 *
	 * @param string $vpsName The name of the VPS
	 * @param string $ipv6Address The Ipv6 Address from your range
	 * @throws ApiException on error
	 */
	public static function addIpv6ToVps($vpsName, $ipv6Address)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $ipv6Address), array('__method' => 'addIpv6ToVps')))->addIpv6ToVps($vpsName, $ipv6Address);
	}

	/**
	 * Update PTR record (reverse DNS) for an ipAddress
	 *
	 * @param string $ipAddress The IP Address to update (ipv4 or ipv6)
	 * @param string $ptrRecord The PTR Record to update to
	 * @throws ApiException on error
	 */
	public static function updatePtrRecord($ipAddress, $ptrRecord)
	{
		return self::_getSoapClient(array_merge(array($ipAddress, $ptrRecord), array('__method' => 'updatePtrRecord')))->updatePtrRecord($ipAddress, $ptrRecord);
	}

	/**
	 * Enable or Disable a Customer Lock for a Vps
	 *
	 * @param string $vpsName The name of the Vps
	 * @param boolean $enabled Enable (true) or Disable (false) the lock
	 * @throws ApiException on error
	 */
	public static function setCustomerLock($vpsName, $enabled)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $enabled), array('__method' => 'setCustomerLock')))->setCustomerLock($vpsName, $enabled);
	}

	/**
	 * Handover a VPS to another TransIP User
	 *
	 * @param string $vpsName The name of the Vps
	 * @param string $targetAccountname the target account name
	 * @throws ApiException on error
	 */
	public static function handoverVps($vpsName, $targetAccountname)
	{
		return self::_getSoapClient(array_merge(array($vpsName, $targetAccountname), array('__method' => 'handoverVps')))->handoverVps($vpsName, $targetAccountname);
	}

	/**
	 * Returns an array of available AvailabilityZones
	 *
	 * @return Transip_AvailabilityZone[] an array of AvailabilityZones
	 */
	public static function getAvailableAvailabilityZones()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAvailableAvailabilityZones')))->getAvailableAvailabilityZones();
	}
}

?>
