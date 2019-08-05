<?php

require_once('ApiSettings.php');
require_once('WebhostingPackage.php');
require_once('WebHost.php');
require_once('Cronjob.php');
require_once('MailBox.php');
require_once('Db.php');
require_once('MailForward.php');
require_once('SubDomain.php');

/**
 * This is the API endpoint for the WebhostingService
 *
 * @package Transip
 * @class WebhostingService
 * @author TransIP (support@transip.nl)
 */
class Transip_WebhostingService
{
	// These fields are SOAP related
	/** The SOAP service that corresponds with this class. */
	const SERVICE = 'WebhostingService';
	/** The API version. */
	const API_VERSION = '5.15';
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
				'WebhostingPackage' => 'Transip_WebhostingPackage',
				'WebHost' => 'Transip_WebHost',
				'Cronjob' => 'Transip_Cronjob',
				'MailBox' => 'Transip_MailBox',
				'Db' => 'Transip_Db',
				'MailForward' => 'Transip_MailForward',
				'SubDomain' => 'Transip_SubDomain',
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
	const TRACK_ENDPOINT_NAME = 'Webhosting';

	/**
	 * Get all domain names that have a webhosting package attached to them.
	 *
	 * @return string[] List of domain names that have a webhosting package
	 */
	public static function getWebhostingDomainNames()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getWebhostingDomainNames')))->getWebhostingDomainNames();
	}

	/**
	 * Get available webhosting packages
	 *
	 * @return Transip_WebhostingPackage[] List of available webhosting packages
	 */
	public static function getAvailablePackages()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAvailablePackages')))->getAvailablePackages();
	}

	/**
	 * Get information about existing webhosting on a domain.
	 * 
	 * Please be aware that the information returned is outdated when
	 * a modifying function in Transip_WebhostingService is called (e.g. createCronjob()).
	 * 
	 * Call this function again to refresh the info.
	 *
	 * @param string $domainName The domain name of the webhosting package to get the info for. Must be owned by this user
	 * @return Transip_WebHost WebHost object with all info about the requested webhosting package
	 */
	public static function getInfo($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getInfo')))->getInfo($domainName);
	}

	/**
	 * Order webhosting for a domain name
	 *
	 * @param string $domainName The domain name to order the webhosting for. Must be owned by this user
	 * @param Transip_WebhostingPackage $webhostingPackage The webhosting Package to order, one of the packages returned by Transip_WebhostingService::getAvailablePackages()
	 * @throws ApiException on error
	 */
	public static function order($domainName, $webhostingPackage)
	{
		return self::_getSoapClient(array_merge(array($domainName, $webhostingPackage), array('__method' => 'order')))->order($domainName, $webhostingPackage);
	}

	/**
	 * Get available upgrades packages for a domain name with webhosting. Only those packages will be returned to which
	 * the given domain name can be upgraded to.
	 *
	 * @param string $domainName Domain to get upgrades for. Must be owned by the current user.
	 * @return Transip_WebhostingPackage[] Available packages to which the domain name can be upgraded to.
	 * @throws ApiException Throwns an Exception ig the domain is not found in the requester account
	 */
	public static function getAvailableUpgrades($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getAvailableUpgrades')))->getAvailableUpgrades($domainName);
	}

	/**
	 * Upgrade the webhosting of a domain name to a new webhosting package to a given new package.
	 *
	 * @param string $domainName The domain to upgrade webhosting for. Must be owned by the current user.
	 * @param string $newWebhostingPackage The new webhosting package, must be one of the packages returned getAvailableUpgrades() for the given domain name
	 * @throws ApiException Throws an exception when the domain name does not belong to the requester (or is not found) or the package can't be upgraded
	 */
	public static function upgrade($domainName, $newWebhostingPackage)
	{
		return self::_getSoapClient(array_merge(array($domainName, $newWebhostingPackage), array('__method' => 'upgrade')))->upgrade($domainName, $newWebhostingPackage);
	}

	/**
	 * Cancel webhosting for a domain
	 *
	 * @param string $domainName The domain to cancel the webhosting for
	 * @param string $endTime the time to cancel the domain (WebhostingService::CANCELLATIONTIME_END (end of contract) or WebhostingService::CANCELLATIONTIME_IMMEDIATELY (as soon as possible))
	 * @throws ApiException Throws an exception when the domain name does not belong to the requester (or is not found).
	 */
	public static function cancel($domainName, $endTime)
	{
		return self::_getSoapClient(array_merge(array($domainName, $endTime), array('__method' => 'cancel')))->cancel($domainName, $endTime);
	}

	/**
	 * Set a new FTP password for a webhosting package
	 *
	 * @param string $domainName Domain to set webhosting FTP password for
	 * @param string $newPassword The new FTP password for the webhosting package
	 * @throws ApiException When the new password is empty
	 */
	public static function setFtpPassword($domainName, $newPassword)
	{
		return self::_getSoapClient(array_merge(array($domainName, $newPassword), array('__method' => 'setFtpPassword')))->setFtpPassword($domainName, $newPassword);
	}

	/**
	 * Create a cronjob
	 *
	 * @param string $domainName the domain name of the webhosting package to create cronjob for
	 * @param Transip_Cronjob $cronjob the cronjob to create. All fields must be valid.
	 * @throws ApiException When the new URL is either invalid or the URL is not a URL linking to the domain the CronJob is for.
	 */
	public static function createCronjob($domainName, $cronjob)
	{
		return self::_getSoapClient(array_merge(array($domainName, $cronjob), array('__method' => 'createCronjob')))->createCronjob($domainName, $cronjob);
	}

	/**
	 * Delete a cronjob from a webhosting package.
	 * Note, all completely matching cronjobs will be removed
	 *
	 * @param string $domainName the domain name of the webhosting package to delete a cronjob
	 * @param Transip_Cronjob $cronjob Cronjob the cronjob to delete. Be aware that all matching cronjobs will be removed.
	 * @throws ApiException When the CronJob that needs to be deleted is not found.
	 */
	public static function deleteCronjob($domainName, $cronjob)
	{
		return self::_getSoapClient(array_merge(array($domainName, $cronjob), array('__method' => 'deleteCronjob')))->deleteCronjob($domainName, $cronjob);
	}

	/**
	 * Creates a MailBox for a webhosting package.
	 * The address field of the MailBox object must be unique.
	 *
	 * @param string $domainName the domain name of the webhosting package to create the mailbox for
	 * @param Transip_MailBox $mailBox MailBox object to create
	 */
	public static function createMailBox($domainName, $mailBox)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailBox), array('__method' => 'createMailBox')))->createMailBox($domainName, $mailBox);
	}

	/**
	 * Modifies MailBox settings
	 *
	 * @param string $domainName the domain name of the webhosting package to modify the mailbox for
	 * @param Transip_MailBox $mailBox the MailBox to modify
	 * @throws ApiException When the MailBox that needs to be modified is not found.
	 */
	public static function modifyMailBox($domainName, $mailBox)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailBox), array('__method' => 'modifyMailBox')))->modifyMailBox($domainName, $mailBox);
	}

	/**
	 * Sets a new password for a MailBox
	 *
	 * @param string $domainName the domain name of the webhosting package to set the mailbox password for
	 * @param Transip_MailBox $mailBox the MailBox to set the password for
	 * @param string $newPassword the new password for the MailBox, cannot be empty.
	 * @throws ApiException When the MailBox that needs to be modified is not found.
	 */
	public static function setMailBoxPassword($domainName, $mailBox, $newPassword)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailBox, $newPassword), array('__method' => 'setMailBoxPassword')))->setMailBoxPassword($domainName, $mailBox, $newPassword);
	}

	/**
	 * Deletes a MailBox from a webhosting package
	 *
	 * @param string $domainName the domain name of the webhosting package to remove the MailBox from
	 * @param Transip_MailBox $mailBox the mailbox object to remove
	 * @throws ApiException When the MailBox that needs to be deleted is not found.
	 */
	public static function deleteMailBox($domainName, $mailBox)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailBox), array('__method' => 'deleteMailBox')))->deleteMailBox($domainName, $mailBox);
	}

	/**
	 * Creates a MailForward for a webhosting package
	 *
	 * @param string $domainName the domain name of the webhosting package to add the MailForward to
	 * @param Transip_MailForward $mailForward The MailForward object to create
	 */
	public static function createMailForward($domainName, $mailForward)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailForward), array('__method' => 'createMailForward')))->createMailForward($domainName, $mailForward);
	}

	/**
	 * Changes an active MailForward object
	 *
	 * @param string $domainName the domain name of the webhosting package to modify the MailForward from
	 * @param Transip_MailForward $mailForward the MailForward to modify
	 * @throws ApiException When the MailForward that needs to be modified is not found.
	 */
	public static function modifyMailForward($domainName, $mailForward)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailForward), array('__method' => 'modifyMailForward')))->modifyMailForward($domainName, $mailForward);
	}

	/**
	 * Deletes an active MailForward object
	 *
	 * @param string $domainName the domain name of the webhosting package to delete the MailForward from
	 * @param Transip_MailForward $mailForward the MailForward to delete
	 */
	public static function deleteMailForward($domainName, $mailForward)
	{
		return self::_getSoapClient(array_merge(array($domainName, $mailForward), array('__method' => 'deleteMailForward')))->deleteMailForward($domainName, $mailForward);
	}

	/**
	 * Creates a new database
	 *
	 * @param string $domainName the domain name of the webhosting package to create the Db for
	 * @param Transip_Db $db Db object to create
	 */
	public static function createDatabase($domainName, $db)
	{
		return self::_getSoapClient(array_merge(array($domainName, $db), array('__method' => 'createDatabase')))->createDatabase($domainName, $db);
	}

	/**
	 * Changes a Db object
	 *
	 * @param string $domainName the domain name of the webhosting package to change the Db for
	 * @param Transip_Db $db The db object to modify
	 */
	public static function modifyDatabase($domainName, $db)
	{
		return self::_getSoapClient(array_merge(array($domainName, $db), array('__method' => 'modifyDatabase')))->modifyDatabase($domainName, $db);
	}

	/**
	 * Sets A database password for a Db
	 *
	 * @param string $domainName the domain name of the webhosting package of the Db to change the password for
	 * @param Transip_Db $db Modified database object to save
	 * @param string $newPassword New password for the database
	 */
	public static function setDatabasePassword($domainName, $db, $newPassword)
	{
		return self::_getSoapClient(array_merge(array($domainName, $db, $newPassword), array('__method' => 'setDatabasePassword')))->setDatabasePassword($domainName, $db, $newPassword);
	}

	/**
	 * Deletes a Db object
	 *
	 * @param string $domainName the domain name of the webhosting package to delete the Db for
	 * @param Transip_Db $db Db object to remove
	 * @throws ApiException When the Database that needs to be deleted is not found.
	 */
	public static function deleteDatabase($domainName, $db)
	{
		return self::_getSoapClient(array_merge(array($domainName, $db), array('__method' => 'deleteDatabase')))->deleteDatabase($domainName, $db);
	}

	/**
	 * Creates a SubDomain
	 *
	 * @param string $domainName the domain name of the webhosting package to create the SubDomain for
	 * @param Transip_SubDomain $subDomain SubDomain object to create
	 */
	public static function createSubdomain($domainName, $subDomain)
	{
		return self::_getSoapClient(array_merge(array($domainName, $subDomain), array('__method' => 'createSubdomain')))->createSubdomain($domainName, $subDomain);
	}

	/**
	 * Deletes a SubDomain
	 *
	 * @param string $domainName the domain name of the webhosting package to delete the SubDomain for
	 * @param Transip_SubDomain $subDomain SubDomain object to delete
	 * @throws ApiException When the Subdomain that needs to be deleted is not found.
	 */
	public static function deleteSubdomain($domainName, $subDomain)
	{
		return self::_getSoapClient(array_merge(array($domainName, $subDomain), array('__method' => 'deleteSubdomain')))->deleteSubdomain($domainName, $subDomain);
	}
}

?>
