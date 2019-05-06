<?php

require_once('ApiSettings.php');
require_once('DataCenterVisitor.php');

/**
 * This is the API endpoint for the ColocationService
 *
 * @package Transip
 * @class ColocationService
 * @author TransIP (support@transip.nl)
 */
class Transip_ColocationService
{
	// These fields are SOAP related
	/** The SOAP service that corresponds with this class. */
	const SERVICE = 'ColocationService';
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
				'DataCenterVisitor' => 'Transip_DataCenterVisitor',
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

	const TRACK_ENDPOINT_NAME = 'Colocation';

	/**
	 * Requests access to the data-center
	 *
	 * @param string $when the datetime of the wanted datacenter access, in YYYY-MM-DD hh:mm:ss format
	 * @param int $duration the expected duration of the visit, in minutes
	 * @param string[] $visitors the names of the visitors for this data-center visit, must be at least 1 and at most 20
	 * @param string $phoneNumber if an SMS with access codes needs to be sent, set the phonenumber of the receiving phone here;
	 * @return Transip_DataCenterVisitor[] An array of Visitor objects holding information (such as reservation and access number) about
	 * @throws ApiException
	 */
	public static function requestAccess($when, $duration, $visitors, $phoneNumber)
	{
		return self::_getSoapClient(array_merge(array($when, $duration, $visitors, $phoneNumber), array('__method' => 'requestAccess')))->requestAccess($when, $duration, $visitors, $phoneNumber);
	}

	/**
	 * Request remote hands to the data-center
	 *
	 * @param string $coloName The name of the colocation
	 * @param string $contactName The contact name
	 * @param string $phoneNumber Phone number to contact
	 * @param int $expectedDuration Expected duration of the job in minutes
	 * @param string $instructions What to do
	 * @throws ApiException
	 */
	public static function requestRemoteHands($coloName, $contactName, $phoneNumber, $expectedDuration, $instructions)
	{
		return self::_getSoapClient(array_merge(array($coloName, $contactName, $phoneNumber, $expectedDuration, $instructions), array('__method' => 'requestRemoteHands')))->requestRemoteHands($coloName, $contactName, $phoneNumber, $expectedDuration, $instructions);
	}

	/**
	 * Get coloNames for customer
	 *
	 * @return string[] Array with colo names
	 */
	public static function getColoNames()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getColoNames')))->getColoNames();
	}

	/**
	 * Get IpAddresses that are active and assigned to a Colo.
	 * Both ipv4 and ipv6 addresses are returned: ipv4 adresses in dot notation,
	 * ipv6 addresses in ipv6 presentation.
	 *
	 * @param string $coloName The name of the colo to get the ipaddresses for for
	 * @return string[] Array with assigned IPv4 and IPv6 addresses for the colo
	 */
	public static function getIpAddresses($coloName)
	{
		return self::_getSoapClient(array_merge(array($coloName), array('__method' => 'getIpAddresses')))->getIpAddresses($coloName);
	}

	/**
	 * Get ipranges that are assigned to a Colo. Both ipv4 and ipv6 ranges are
	 * returned, in CIDR notation.
	 *
	 * @param string $coloName The name of the colo to get the ranges for
	 * @see http://en.wikipedia.org/wiki/CIDR_notation
	 * @return string[] Array of ipranges in CIDR format assigned to this colo.
	 */
	public static function getIpRanges($coloName)
	{
		return self::_getSoapClient(array_merge(array($coloName), array('__method' => 'getIpRanges')))->getIpRanges($coloName);
	}

	/**
	 * Adds a new IpAddress, either an ipv6 or an ipv4 address.
	 * The service will validate the address, ensure the user is entitled
	 * to the address and will add the address to the correct Colo and range.
	 *
	 * @param string $ipAddress The IpAddress to create, can be either ipv4 or ipv6.
	 * @param string $reverseDns The RDNS name for this IpAddress
	 * @throws ApiException
	 */
	public static function createIpAddress($ipAddress, $reverseDns)
	{
		return self::_getSoapClient(array_merge(array($ipAddress, $reverseDns), array('__method' => 'createIpAddress')))->createIpAddress($ipAddress, $reverseDns);
	}

	/**
	 * Deletes an IpAddress currently in use this account.
	 * IpAddress can be either ipv4 or ipv6. The service will validate
	 * if the user has rights to remove the address and will remove it completely,
	 * together with any RDNS or monitoring assigned to the address.
	 *
	 * @param string $ipAddress the IpAddress to delete, can be either ipv4 or ipv6.
	 */
	public static function deleteIpAddress($ipAddress)
	{
		return self::_getSoapClient(array_merge(array($ipAddress), array('__method' => 'deleteIpAddress')))->deleteIpAddress($ipAddress);
	}

	/**
	 * Get the Reverse DNS for an IpAddress assigned to the user
	 * Throws an Exception when the Address does not exist or is not
	 * owned by the user.
	 *
	 * @param string $ipAddress the IpAddress, either ipv4 or ipv6
	 * @return string rdns
	 */
	public static function getReverseDns($ipAddress)
	{
		return self::_getSoapClient(array_merge(array($ipAddress), array('__method' => 'getReverseDns')))->getReverseDns($ipAddress);
	}

	/**
	 * Set the RDNS name for an ipAddress.
	 * Throws an Exception when the Address does not exist or is not
	 * owned by the user.
	 *
	 * @param string $ipAddress The IpAddress to set the reverse dns for, can be either ipv4 or ipv6.
	 * @param string $reverseDns The new reverse DNS, must be a valid RDNS value.
	 */
	public static function setReverseDns($ipAddress, $reverseDns)
	{
		return self::_getSoapClient(array_merge(array($ipAddress, $reverseDns), array('__method' => 'setReverseDns')))->setReverseDns($ipAddress, $reverseDns);
	}
}

?>
