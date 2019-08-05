<?php

require_once('ApiSettings.php');
require_once('DnsEntry.php');
require_once('DnsSecEntry.php');

/**
 * This is the API endpoint for the DnsService
 *
 * @package Transip
 * @class DnsService
 * @author TransIP (support@transip.nl)
 */
class Transip_DnsService
{
	// These fields are SOAP related
	/** The SOAP service that corresponds with this class. */
	const SERVICE = 'DnsService';
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
				'DnsEntry' => 'Transip_DnsEntry',
				'DnsSecEntry' => 'Transip_DnsSecEntry',
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

	const TRACK_ENDPOINT_NAME = 'Dns';

	/**
	 * Sets the DnEntries for this Domain, will replace all existing dns entries with the new entries
	 *
	 * @param string $domainName the domainName to change the dns entries for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @param Transip_DnsEntry[] $dnsEntries the list of new DnsEntries for this domain
	 * @example examples/DnsService-setDnsEntries.php
	 */
	public static function setDnsEntries($domainName, $dnsEntries)
	{
		return self::_getSoapClient(array_merge(array($domainName, $dnsEntries), array('__method' => 'setDnsEntries')))->setDnsEntries($domainName, $dnsEntries);
	}

	/**
	 * Checks if the dnssec entries of a domain can be updated.
	 *
	 * @param string $domainName 
	 * @return boolean 
	 * @example examples/DnsService-setDnsSecEntries.php
	 */
	public static function canEditDnsSec($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'canEditDnsSec')))->canEditDnsSec($domainName);
	}

	/**
	 * 
	 *
	 * @param string $domainName 
	 * @return Transip_DnsSecEntry[] 
	 * @example examples/DnsService-getDnsSecEntries.php
	 */
	public static function getDnsSecEntries($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getDnsSecEntries')))->getDnsSecEntries($domainName);
	}

	/**
	 * Sets new DNSSEC key entries for a domain, replacing the current ones.
	 *
	 * @param string $domainName 
	 * @param Transip_DnsSecEntry[] $dnssecKeyEntrySet 
	 * @example examples/DnsService-setDnsSecEntries.php
	 */
	public static function setDnsSecEntries($domainName, $dnssecKeyEntrySet)
	{
		return self::_getSoapClient(array_merge(array($domainName, $dnssecKeyEntrySet), array('__method' => 'setDnsSecEntries')))->setDnsSecEntries($domainName, $dnssecKeyEntrySet);
	}

	/**
	 * Remove all the DnsSecEntries from a domain.
	 *
	 * @param string $domainName 
	 * @example examples/DnsService-setDnsSecEntries.php
	 */
	public static function removeAllDnsSecEntries($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'removeAllDnsSecEntries')))->removeAllDnsSecEntries($domainName);
	}
}

?>
