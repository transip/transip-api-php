<?php

require_once('ApiSettings.php');
require_once('DomainCheckResult.php');
require_once('Domain.php');
require_once('Nameserver.php');
require_once('WhoisContact.php');
require_once('DnsEntry.php');
require_once('DomainBranding.php');
require_once('Tld.php');
require_once('DomainAction.php');

/**
 * This is the API endpoint for the DomainService
 *
 * @package Transip
 * @class DomainService
 * @author TransIP (support@transip.nl)
 */
class Transip_DomainService
{
	// These fields are SOAP related
	/** The SOAP service that corresponds with this class. */
	const SERVICE = 'DomainService';
	/** The API version. */
	const API_VERSION = '5.22';
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
				'DomainCheckResult' => 'Transip_DomainCheckResult',
				'Domain' => 'Transip_Domain',
				'Nameserver' => 'Transip_Nameserver',
				'WhoisContact' => 'Transip_WhoisContact',
				'DnsEntry' => 'Transip_DnsEntry',
				'DomainBranding' => 'Transip_DomainBranding',
				'Tld' => 'Transip_Tld',
				'DomainAction' => 'Transip_DomainAction',
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

	const AVAILABILITY_INYOURACCOUNT = 'inyouraccount';
	const AVAILABILITY_UNAVAILABLE = 'unavailable';
	const AVAILABILITY_NOTFREE = 'notfree';
	const AVAILABILITY_FREE = 'free';
	const AVAILABILITY_INTERNALPULL = 'internalpull';
	const CANCELLATIONTIME_END = 'end';
	const CANCELLATIONTIME_IMMEDIATELY = 'immediately';
	const ACTION_REGISTER = 'register';
	const ACTION_TRANSFER = 'transfer';
	const ACTION_INTERNALPULL = 'internalpull';
	const TRACK_ENDPOINT_NAME = 'Domain';

	/**
	 * Checks the availability of multiple domains.
	 *
	 * @param string[] $domainNames The domain names to check for availability.<br /><br />- A maximum of 20 domainNames at once can be checked.<br />- domainNames must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @example examples/DomainService-batchCheckAvailability.php
	 * @throws ApiException
	 * @return Transip_DomainCheckResult[] A list of DomainCheckResult objects, holding the domainName and the status per result.
	 */
	public static function batchCheckAvailability($domainNames)
	{
		return self::_getSoapClient(array_merge(array($domainNames), array('__method' => 'batchCheckAvailability')))->batchCheckAvailability($domainNames);
	}

	/**
	 * Checks the availability of a domain.
	 *
	 * @param string $domainName The domain name to check for availability.<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @return string the availability status of the domain name:<br /><br />- free                the domain is free for registration<br />- notfree            the domain is not free for new registration, but can possibly be transferred<br />- inyouraccount        the domain is already in your account<br />- unavailable        the domain is not available for registration
	 * @example examples/DomainService-checkAvailability.php
	 */
	public static function checkAvailability($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'checkAvailability')))->checkAvailability($domainName);
	}

	/**
	 * Gets the whois of a domain name
	 *
	 * @param string $domainName the domain name to get the whois for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @return string the whois data for the domain
	 * @throws ApiException
	 * @example examples/DomainService-getWhois.php
	 */
	public static function getWhois($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getWhois')))->getWhois($domainName);
	}

	/**
	 * Gets the names of all domains in your account.
	 *
	 * @return string[] A list of all domains in your account
	 * @example examples/DomainService-getDomainNames.php
	 */
	public static function getDomainNames()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getDomainNames')))->getDomainNames();
	}

	/**
	 * Get information about a domainName.
	 *
	 * @param string $domainName The domainName to get the information for.<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @example examples/DomainService-DomainService-getInfo.php
	 * @throws ApiException  If the Domain could not be found.
	 * @return Transip_Domain A Domain object holding the data for the requested domainName.
	 */
	public static function getInfo($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getInfo')))->getInfo($domainName);
	}

	/**
	 * Get information about a list of Domain names.
	 *
	 * @param string[] $domainNames A list of Domain names you want information for.<br /><br />- domainNames must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @throws Exception     If something else went wrong.
	 * @return Transip_Domain[] Domain objects.
	 */
	public static function batchGetInfo($domainNames)
	{
		return self::_getSoapClient(array_merge(array($domainNames), array('__method' => 'batchGetInfo')))->batchGetInfo($domainNames);
	}

	/**
	 * Gets the Auth code for a domainName
	 *
	 * @param string $domainName the domainName to get the authcode for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @deprecated
	 * @return string the authentication code for a domain name
	 * @example examples/DomainService-DomainService-getAuthCode.php
	 */
	public static function getAuthCode($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getAuthCode')))->getAuthCode($domainName);
	}

	/**
	 * Gets the lock status for a domainName
	 *
	 * @param string $domainName the domainName to get the lock status for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @return boolean true iff the domain is locked at the registry
	 * @deprecated use getInfo()
	 */
	public static function getIsLocked($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getIsLocked')))->getIsLocked($domainName);
	}

	/**
	 * Will get additional contact data fields for domain.
	 * 
	 * <br />
	 * 
	 * <b>COUNTRY_CODE</b>: A 2 letter country from the <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Decoding_table" target="_blanc">ISO 3166-1 alpha-2 standard</a>. <br />
	 * <b>PERSONAL_IDENTIFICATION_NUMBER</b>: Your personal id number when registering as a natural person. Kvk when registering as a company. <br />
	 * <b>REGISTRANT_TYPE</b>: Fill in whether you register the domain name as a person or as a company. <br />
	 * <b>VAT_NUMBER</b>: A valid VAT number is required to register this domain. <br />
	 * <b>FIRST_NAME</b>: Your full first name has to be provided here.<br />
	 * <b>LAST_NAME</b>: Your full last name has to be provided here.<br />
	 * <b>BIRTH_DATE</b>: You have to supply your birth date here. Please do so in the format ‘YYYY-MM-DD’.<br />
	 * <b>COMPANY_REGISTRATION_ID</b>: Please provide the company registration id if the domain is being registered on behalf of or by a company.<br />
	 * <b>INTENDED_USE</b>: You should provide a short explanation on what you are going to use this domain for.<br />
	 * <b>CODICE_FISCALE</b>: A valid Codice Fiscale (16 characters) is required to register this domain.<br />
	 * <b>ADMIN_IDENTIFICATION_NUMBER</b>: Provide the identifier for the adminstrative contact. For example a personal id.<br />
	 * <b>ADMIN_IDENTIFICATION_TYPE</b>: Administrative contact Identification type<br />
	 * <b>OWNER_IDENTIFICATION_NUMBER</b>: Provide the identifier for the holder. For example a personal id or AVT.<br />
	 * <b>OWNER_IDENTIFICATION_TYPE</b>: Holder Identifier type<br />
	 * <b>OWNER_LEGAL_FORM</b>: Select the legal form for the holder.<br />
	 * <b>TECH_IDENTIFICATION_NUMBER</b>: Provide the identifier for the technical contact. For example a personal id.<br />
	 * <b>TECH_IDENTIFICATION_TYPE</b>: Technical contact Identifier type<br />
	 * <b>OWNER_VAT_NUMBER</b>: For the registration of this domain a valid VAT number of the registrant is required<br />
	 * <b>TECH_VAT_NUMBER</b>: For the registration of this domain a valid VAT number of the technical contact is required<br />
	 * <b>COMMUNITY_ID</b>: The community ID from the Sponsored Community is a unique code that consists of 16 characters.<br />
	 * <b>LEGAL_FORM_DUTCH</b>: Choose legalform<br />
	 * 
	 * <br />
	 * 
	 * Tld specific cases <br />
	 * 
	 * <b>.amsterdam</b> <br />
	 * Choose one of the following options for LEGAL_FORM_DUTCH: ANDERS, BGG, BRO, BV, BVI/O, COOP, CV, EENMANSZAAK, EESV, KERK, MAATSCHAP, NV, OWM, PERSOON, REDR, STICHTING, VERENIGING, VOF <br />
	 * 
	 * <br />
	 * 
	 * <b>.es and .com.es</b> <br />
	 * For ADMIN_IDENTIFICATION_TYPE, OWNER_IDENTIFICATION_TYPE and TECH_IDENTIFICATION_TYPE use following values: <br />
	 * For Non Spanish identification number use: <b>0</b> <br />
	 * For Spanish identification number use: <b>1</b> <br />
	 * For Spanish identification number for residents use: <b>3</b> <br />
	 * 
	 * <br />
	 * 
	 * <b>.fr</b> <br />
	 * If registering as a person use: FIRST_NAME, LAST_NAME. <br />
	 * If registering as a company use: FIRST_NAME, LAST_NAME, VAT_NUMBER, COUNTRY_CODE <br />
	 * 
	 * <br />
	 * 
	 * <b>.it</b> <br />
	 * <b>1.</b> Use only COUNTRY_CODE in NOT any of the following codes: AT, BE, CY, CZ, DE, DK, EE, ES, FI, FR, GB, GR, HU, IE, LT, LU, LV, MT, NL, PL, PT, SE, SI, SK, BG or RO <br />
	 * <b>2.</b> If COUNTRY_CODE is IT use: COUNTRY_CODE and CODICE_FISCALE <br />
	 * <b>3.</b> If REGISTRANT_TYPE is company and COUNTRY_CODE is any of the following: AT, BE, CY, CZ, DE, DK, EE, ES, FI, FR, GB, GR, HU, IE, LT, LU, LV, MT, NL, PL, PT, SE, SI, SK, BG or RO use: COUNTRY_CODE, REGISTRANT_TYPE and VAT_NUMBER <br />
	 * <b>4.</b> If REGISTRANT_TYPE is person and COUNTRY_CODE is any of the following: AT, BE, CY, CZ, DE, DK, EE, ES, FI, FR, GB, GR, HU, IE, LT, LU, LV, MT, NL, PL, PT, SE, SI, SK, BG or RO use: COUNTRY_CODE, REGISTRANT_TYPE and PERSONAL_IDENTIFICATION_NUMBER <br />
	 * 
	 * <br />
	 * 
	 * <b>.nu</b> <br />
	 * <b>1.</b> Use only PERSONAL_IDENTIFICATION_NUMBER when registrant is a person <br />
	 * <b>2.</b> If ordering as a company and VAT_COUNTRY_CODE is NOT: AT, BE, CY, CZ, DE, DK, EE, ES, FI, FR, GB, GR, HU, IE, IT, LT, LU, LV, MT, NL, PL, PT, SE, SI, SK, BG, RO use PERSONAL_IDENTIFICATION_NUMBER and VAT_COUNTRY_CODE <br />
	 * <b>3.</b> If ordering as a company and VAT_COUNTRY_CODE is one of the following: AT, BE, CY, CZ, DE, DK, EE, ES, FI, FR, GB, GR, HU, IE, IT, LT, LU, LV, MT, NL, PL, PT, SE, SI, SK, BG, RO use PERSONAL_IDENTIFICATION_NUMBER, VAT_COUNTRY_CODE and VAT_NUMBER <br />
	 * 
	 * <br />
	 * 
	 * <b>.pm, .re, .tf, .wf and .yt</b> <br />
	 * <b>1.</b> If registering as a person use: FIRST_NAME and LAST_NAME <br />
	 * <b>2.</b> If registering as a company use: VAT_NUMBER, VAT_COUNTRY_CODE, FIRST_NAME and LAST_NAME <br />
	 * 
	 * <br />
	 * 
	 * <b>.se</b> <br />
	 * <b>1.</b> If registering as a person use: PERSONAL_IDENTIFICATION_NUMBER <br />
	 * <b>2.</b> If registering as a company use: PERSONAL_IDENTIFICATION_NUMBER, VAT_COUNTRY_CODE and VAT_NUMBER
	 *
	 * @param string $domainName 
	 * @example examples/DomainService-DomainService-getExtraContactFields.php
	 * @return string[] 
	 */
	public static function getExtraContactFields($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getExtraContactFields')))->getExtraContactFields($domainName);
	}

	/**
	 * Registers a domain name, will automatically create and sign a proposition for it
	 *
	 * @param Transip_Domain $domain The Domain object holding information about the domain that needs to be registered.
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-register-whois.php
	 * @return string proposition number
	 * @throws UserException
	 */
	public static function register($domain)
	{
		return self::_getSoapClient(array_merge(array($domain), array('__method' => 'register')))->register($domain);
	}

	/**
	 * Registers a domain name, will automatically create and sign a proposition for it
	 *
	 * @param Transip_Domain $domain The Domain object holding information about the domain that needs to be registered.
	 * @param string[] $extraContactFields The ExtraContactFields that are required for this domain.
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-register-whois.php
	 * @return string proposition number
	 * @throws UserException
	 */
	public static function registerWithExtraContactFields($domain, $extraContactFields)
	{
		return self::_getSoapClient(array_merge(array($domain, $extraContactFields), array('__method' => 'registerWithExtraContactFields')))->registerWithExtraContactFields($domain, $extraContactFields);
	}

	/**
	 * Cancels a domain name, will automatically create and sign a cancellation document
	 * Please note that domains with webhosting cannot be cancelled through the API
	 *
	 * @param string $domainName The domainname that needs to be cancelled.<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @param string $endTime The time to cancel the domain (DomainService::CANCELLATIONTIME_END (end of contract)
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-cancel.php
	 * @throws ApiException
	 */
	public static function cancel($domainName, $endTime)
	{
		return self::_getSoapClient(array_merge(array($domainName, $endTime), array('__method' => 'cancel')))->cancel($domainName, $endTime);
	}

	/**
	 * Transfers a domain without changing the owner
	 *
	 * @param Transip_Domain $domain the Domain object holding information about the domain that needs to be transfered
	 * @param string $authCode the authorization code for domains needing this for transfers (e.g. .com or .org transfers). Leave empty when n/a.
	 * @return string proposition number
	 * @throws UserException
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-transfer.php
	 */
	public static function transferWithOwnerChange($domain, $authCode)
	{
		return self::_getSoapClient(array_merge(array($domain, $authCode), array('__method' => 'transferWithOwnerChange')))->transferWithOwnerChange($domain, $authCode);
	}

	/**
	 * Transfers a domain with changing the owner, not all TLDs support this (e.g. nl)
	 *
	 * @param Transip_Domain $domain the Domain object holding information about the domain that needs to be transfered
	 * @param string $authCode the authorization code for domains needing this for transfers (e.g. .com or .org transfers). Leave empty when n/a.
	 * @param string[] $extraContactFields The ExtraContactFields that are required for this domain.
	 * @return string proposition number
	 * @throws UserException
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-transfer.php
	 */
	public static function transferWithOwnerChangeWithExtraContactFields($domain, $authCode, $extraContactFields)
	{
		return self::_getSoapClient(array_merge(array($domain, $authCode, $extraContactFields), array('__method' => 'transferWithOwnerChangeWithExtraContactFields')))->transferWithOwnerChangeWithExtraContactFields($domain, $authCode, $extraContactFields);
	}

	/**
	 * Transfers a domain without changing the owner
	 *
	 * @param Transip_Domain $domain the Domain object holding information about the domain that needs to be transfered
	 * @param string $authCode the authorization code for domains needing this for transfers (e.g. .com or .org transfers). Leave empty when n/a.
	 * @return string proposition number
	 * @throws UserException
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-transfer.php
	 */
	public static function transferWithoutOwnerChange($domain, $authCode)
	{
		return self::_getSoapClient(array_merge(array($domain, $authCode), array('__method' => 'transferWithoutOwnerChange')))->transferWithoutOwnerChange($domain, $authCode);
	}

	/**
	 * Transfers a domain without changing the owner
	 *
	 * @param Transip_Domain $domain the Domain object holding information about the domain that needs to be transfered
	 * @param string $authCode the authorization code for domains needing this for transfers (e.g. .com or .org transfers). Leave empty when n/a.
	 * @param string[] $extraContactFields The ExtraContactFields that are required for this domain.
	 * @return string proposition number
	 * @throws UserException
	 * @requires readwrite mode
	 * @example examples/DomainService-DomainService-transfer.php
	 */
	public static function transferWithoutOwnerChangeWithExtraContactFields($domain, $authCode, $extraContactFields)
	{
		return self::_getSoapClient(array_merge(array($domain, $authCode, $extraContactFields), array('__method' => 'transferWithoutOwnerChangeWithExtraContactFields')))->transferWithoutOwnerChangeWithExtraContactFields($domain, $authCode, $extraContactFields);
	}

	/**
	 * Starts a nameserver change for this domain, will replace all existing nameservers with the new nameservers
	 *
	 * @param string $domainName the domainName to change the nameservers for <br /><br /> domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @param Transip_Nameserver[] $nameservers the list of new nameservers for this domain
	 * @example examples/DomainService-DomainService-setNameservers.php
	 */
	public static function setNameservers($domainName, $nameservers)
	{
		return self::_getSoapClient(array_merge(array($domainName, $nameservers), array('__method' => 'setNameservers')))->setNameservers($domainName, $nameservers);
	}

	/**
	 * Lock this domain in real time
	 *
	 * @param string $domainName the domainName to set the lock for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @example examples/DomainService-DomainService-setLock.php
	 */
	public static function setLock($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'setLock')))->setLock($domainName);
	}

	/**
	 * unlocks this domain in real time
	 *
	 * @param string $domainName the domainName to unlock<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @example examples/DomainService-DomainService-setLock.php
	 */
	public static function unsetLock($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'unsetLock')))->unsetLock($domainName);
	}

	/**
	 * Sets the DnEntries for this Domain, will replace all existing dns entries with the new entries
	 *
	 * @param string $domainName the domainName to change the dns entries for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @param Transip_DnsEntry[] $dnsEntries the list of new DnsEntries for this domain
	 * @deprecated Use DnsService.setDnsEntries instead.
	 */
	public static function setDnsEntries($domainName, $dnsEntries)
	{
		return self::_getSoapClient(array_merge(array($domainName, $dnsEntries), array('__method' => 'setDnsEntries')))->setDnsEntries($domainName, $dnsEntries);
	}

	/**
	 * Starts an owner change of a Domain, brings additional costs with the following TLDs:
	 * .be
	 *
	 * @param string $domainName the domainName to change the owner for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @param Transip_WhoisContact $registrantWhoisContact the new contact data for this
	 * @example examples/DomainService-DomainService-setOwner.php
	 * @throws ApiException
	 */
	public static function setOwner($domainName, $registrantWhoisContact)
	{
		return self::_getSoapClient(array_merge(array($domainName, $registrantWhoisContact), array('__method' => 'setOwner')))->setOwner($domainName, $registrantWhoisContact);
	}

	/**
	 * Starts a contact change of a domain, this will replace all existing contacts
	 *
	 * @param string $domainName the domainName to change the contacts for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @param Transip_WhoisContact[] $contacts the list of new contacts for this domain
	 * @throws ApiException
	 * @example examples/DomainService-DomainService-setContacts.php
	 */
	public static function setContacts($domainName, $contacts)
	{
		return self::_getSoapClient(array_merge(array($domainName, $contacts), array('__method' => 'setContacts')))->setContacts($domainName, $contacts);
	}

	/**
	 * Get TransIP supported TLDs
	 *
	 * @return Transip_Tld[] Array of Tld objects
	 * @example examples/DomainService-DomainService-getAllTldInfos.php
	 */
	public static function getAllTldInfos()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getAllTldInfos')))->getAllTldInfos();
	}

	/**
	 * Get info about a specific TLD
	 *
	 * @param string $tldName The tld to get information about.<br /><br />- tldName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @example examples/DomainService-DomainService-getAllTldInfos.php
	 * @throws ApiException  If the TLD could not be found.
	 * @return Transip_Tld Tld object with info about this Tld
	 */
	public static function getTldInfo($tldName)
	{
		return self::_getSoapClient(array_merge(array($tldName), array('__method' => 'getTldInfo')))->getTldInfo($tldName);
	}

	/**
	 * Gets info about the action this domain is currently running
	 *
	 * @param string $domainName Name of the domain<br /><br />- domainName must meet the requirements specified in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>.
	 * @return Transip_DomainAction if this domain is currently running an action, a corresponding DomainAction with info about the action will be returned. If there is no action running, null will be returned.
	 * @example examples/DomainService-DomainService-domainActions.php
	 */
	public static function getCurrentDomainAction($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getCurrentDomainAction')))->getCurrentDomainAction($domainName);
	}

	/**
	 * Retries a failed domain action with new domain data. The Domain#name field must contain
	 * the name of the Domain, the nameserver, contacts, dnsEntries fields contain the new data for this domain.
	 * Set a field to null to not change the data.
	 *
	 * @param Transip_Domain $domain The domain with data to retry
	 * @example examples/DomainService-DomainService-domainActions.php
	 * @throws ApiException
	 */
	public static function retryCurrentDomainActionWithNewData($domain)
	{
		return self::_getSoapClient(array_merge(array($domain), array('__method' => 'retryCurrentDomainActionWithNewData')))->retryCurrentDomainActionWithNewData($domain);
	}

	/**
	 * Retry a transfer action with a new authcode
	 *
	 * @param Transip_Domain $domain The domain to try the transfer with a different authcode for
	 * @param string $newAuthCode New authorization code to try
	 * @example examples/DomainService-DomainService-domainActions.php
	 * @throws ApiException
	 */
	public static function retryTransferWithDifferentAuthCode($domain, $newAuthCode)
	{
		return self::_getSoapClient(array_merge(array($domain, $newAuthCode), array('__method' => 'retryTransferWithDifferentAuthCode')))->retryTransferWithDifferentAuthCode($domain, $newAuthCode);
	}

	/**
	 * Cancels a failed domain action
	 *
	 * @param Transip_Domain $domain the domain to cancel the action for
	 * @example examples/DomainService-DomainService-domainActions.php
	 * @throws ApiException
	 */
	public static function cancelDomainAction($domain)
	{
		return self::_getSoapClient(array_merge(array($domain), array('__method' => 'cancelDomainAction')))->cancelDomainAction($domain);
	}

	/**
	 * Request the authcode at the registry
	 * 
	 * This function will request the authcode for domains at DNS.be and EURid from the registry
	 *
	 * @param string $domainName the domainNAme to request the autocode for<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @return string|null the authentication code for the domain name (or null)
	 * @throws ApiException
	 */
	public static function requestAuthCode($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'requestAuthCode')))->requestAuthCode($domainName);
	}

	/**
	 * Handover a Domain to another TransIP User. Please be aware that this will NOT change the owner contact information
	 * at the registry. If you want to change the domain owner at the registry, then you should execute a 'setOwner'.
	 *
	 * @param string $domainName The domain name you want to hand over.
	 * @param string $targetAccountname The target account name.
	 * @throws ApiException on error
	 */
	public static function handover($domainName, $targetAccountname)
	{
		return self::_getSoapClient(array_merge(array($domainName, $targetAccountname), array('__method' => 'handover')))->handover($domainName, $targetAccountname);
	}

	/**
	 * Handover a TransIP Domain to your account by using an auth code. Please be aware that this will NOT change the owner contact information
	 * at the registry. If you want to change the domain owner at the registry, then you should execute a 'setOwner'.
	 *
	 * @param string $domainName The domain name you want to handover with an auth code.
	 * @param string $authCode The auth code to authorize the handover.
	 * @throws ApiException
	 */
	public static function handoverWithAuthCode($domainName, $authCode)
	{
		return self::_getSoapClient(array_merge(array($domainName, $authCode), array('__method' => 'handoverWithAuthCode')))->handoverWithAuthCode($domainName, $authCode);
	}

	/**
	 * Get Default DNS Entries for a customer.
	 *
	 * @return Transip_DnsEntry[] A list of the default Dns Entries for the currently authenticated user
	 * @throws ApiException If there are not default values
	 */
	public static function getDefaultDnsEntries()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getDefaultDnsEntries')))->getDefaultDnsEntries();
	}

	/**
	 * Get Default DNS Entries for a specific domain
	 *
	 * @param string $domainName The domainName to get the information for.<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @return Transip_DnsEntry[] A list of the default DNS entries for this domain
	 * @throws ApiException  If the domain could not be found.
	 */
	public static function getDefaultDnsEntriesByDomainName($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getDefaultDnsEntriesByDomainName')))->getDefaultDnsEntriesByDomainName($domainName);
	}

	/**
	 * Get Default Nameservers for a customer
	 *
	 * @return Transip_Nameserver[] A list of Nameservers for the currently authenticated API User
	 * @throws ApiException
	 */
	public static function getDefaultNameservers()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getDefaultNameservers')))->getDefaultNameservers();
	}

	/**
	 * Get the Default nameservers for the given domain.
	 *
	 * @param string $domainName The domainName to get the information for.<br /><br />- domainName must meet the requirements for a domain name described in: <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 * @return Transip_Nameserver[] A list of the default Nameservers for this domain
	 * @throws ApiException If the domain could not be found
	 */
	public static function getDefaultNameserversByDomainName($domainName)
	{
		return self::_getSoapClient(array_merge(array($domainName), array('__method' => 'getDefaultNameserversByDomainName')))->getDefaultNameserversByDomainName($domainName);
	}
}

?>
