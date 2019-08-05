<?php

require_once('ApiSettings.php');
require_once('Haip.php');
require_once('Vps.php');

/**
 * This is the API endpoint for the HaipService
 *
 * @package Transip
 * @class HaipService
 * @author TransIP (support@transip.nl)
 */
class Transip_HaipService
{
	// These fields are SOAP related
	/** The SOAP service that corresponds with this class. */
	const SERVICE = 'HaipService';
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
				'Haip' => 'Transip_Haip',
				'Vps' => 'Transip_Vps',
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

	const TRACK_ENDPOINT_NAME = 'HA-IP';
	const CANCELLATIONTIME_END = 'end';
	const CANCELLATIONTIME_IMMEDIATELY = 'immediately';

	/**
	 * Get a HA-IP by name
	 *
	 * @param string $haipName The HA-IP name
	 * @throws ApiException
	 * @return Transip_Haip The vps objects
	 */
	public static function getHaip($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getHaip')))->getHaip($haipName);
	}

	/**
	 * Get all HA-IPs
	 *
	 * @return Transip_Haip[] Array of HA-IP objects
	 */
	public static function getHaips()
	{
		return self::_getSoapClient(array_merge(array(), array('__method' => 'getHaips')))->getHaips();
	}

	/**
	 * Changes the VPS connected to the HA-IP.
	 *
	 * @param string $haipName The HA-IP name
	 * @param string $vpsName The Vps name
	 * @throws ApiException
	 */
	public static function changeHaipVps($haipName, $vpsName)
	{
		return self::_getSoapClient(array_merge(array($haipName, $vpsName), array('__method' => 'changeHaipVps')))->changeHaipVps($haipName, $vpsName);
	}

	/**
	 * Replaces currently attached VPSes to the HA-IP with the provided list of VPSes.
	 *
	 * @param string $haipName The HA-IP name
	 * @param string[] $vpsNames The Vps names
	 * @throws ApiException
	 */
	public static function setHaipVpses($haipName, $vpsNames)
	{
		return self::_getSoapClient(array_merge(array($haipName, $vpsNames), array('__method' => 'setHaipVpses')))->setHaipVpses($haipName, $vpsNames);
	}

	/**
	 * Sets the provided IP setup for the HA-IP.
	 *
	 * @param string $haipName The HA-IP name
	 * @param string $ipSetup The IP setup ('both','noipv6','ipv6to4')
	 * @throws ApiException
	 */
	public static function setIpSetup($haipName, $ipSetup)
	{
		return self::_getSoapClient(array_merge(array($haipName, $ipSetup), array('__method' => 'setIpSetup')))->setIpSetup($haipName, $ipSetup);
	}

	/**
	 * Sets the provided balancing mode for the HA-IP. The cookieName argument may be an empty string unless the
	 * balancing mode is set to 'cookie'.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @param string $haipName The HA-IP name
	 * @param string $balancingMode The balancing mode ('roundrobin','cookie','source')
	 * @param string $cookieName The cookie name that pins the session if the balancing mode is 'cookie'
	 * @throws ApiException
	 */
	public static function setBalancingMode($haipName, $balancingMode, $cookieName)
	{
		return self::_getSoapClient(array_merge(array($haipName, $balancingMode, $cookieName), array('__method' => 'setBalancingMode')))->setBalancingMode($haipName, $balancingMode, $cookieName);
	}

	/**
	 * Configures a HTTP health check for the HA-IP. To disable a HTTP health check use setTcpHealthCheck().
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @param string $haipName The HA-IP name
	 * @param string $path The path that will be accessed when performing health checks
	 * @param int $port The port that will be used when performing health checks
	 * @throws ApiException
	 */
	public static function setHttpHealthCheck($haipName, $path, $port)
	{
		return self::_getSoapClient(array_merge(array($haipName, $path, $port), array('__method' => 'setHttpHealthCheck')))->setHttpHealthCheck($haipName, $path, $port);
	}

	/**
	 * Configures a TCP health check for the HA-IP (this is the default health check).
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @param string $haipName The HA-IP name
	 * @throws ApiException
	 */
	public static function setTcpHealthCheck($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'setTcpHealthCheck')))->setTcpHealthCheck($haipName);
	}

	/**
	 * Get a status report for the HA-IP.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @param string $haipName The HA-IP name
	 * @throws ApiException
	 * @return array 
	 */
	public static function getStatusReport($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getStatusReport')))->getStatusReport($haipName);
	}

	/**
	 * Get all Certificates by Haip
	 *
	 * @param string $haipName 
	 * @throws ApiException
	 * @return array 
	 */
	public static function getCertificatesByHaip($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getCertificatesByHaip')))->getCertificatesByHaip($haipName);
	}

	/**
	 * Get all available certificates ready to attach to your HAIP
	 *
	 * @param string $haipName 
	 * @throws ApiException
	 * @return array 
	 */
	public static function getAvailableCertificatesByHaip($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getAvailableCertificatesByHaip')))->getAvailableCertificatesByHaip($haipName);
	}

	/**
	 * Add a HaipCertificate to this object
	 *
	 * @param string $haipName 
	 * @param int $certificateId 
	 * @throws ApiException
	 */
	public static function addCertificateToHaip($haipName, $certificateId)
	{
		return self::_getSoapClient(array_merge(array($haipName, $certificateId), array('__method' => 'addCertificateToHaip')))->addCertificateToHaip($haipName, $certificateId);
	}

	/**
	 * Removes a Certificate from this HA-IP
	 *
	 * @param string $haipName 
	 * @param int $certificateId 
	 * @throws ApiException
	 */
	public static function deleteCertificateFromHaip($haipName, $certificateId)
	{
		return self::_getSoapClient(array_merge(array($haipName, $certificateId), array('__method' => 'deleteCertificateFromHaip')))->deleteCertificateFromHaip($haipName, $certificateId);
	}

	/**
	 * Add EncryptCertificate to HA-IP
	 *
	 * @param string $haipName 
	 * @param string $commonName 
	 * @throws ApiException
	 */
	public static function startHaipLetsEncryptCertificateIssue($haipName, $commonName)
	{
		return self::_getSoapClient(array_merge(array($haipName, $commonName), array('__method' => 'startHaipLetsEncryptCertificateIssue')))->startHaipLetsEncryptCertificateIssue($haipName, $commonName);
	}

	/**
	 * Returns the current ptr for the given HA-IP
	 *
	 * @param string $haipName 
	 * @throws ApiException
	 * @return string 
	 */
	public static function getPtrForHaip($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getPtrForHaip')))->getPtrForHaip($haipName);
	}

	/**
	 * Update the ptr records for the given HA-IP
	 *
	 * @param string $haipName 
	 * @param string $ptr 
	 * @throws ApiException
	 */
	public static function setPtrForHaip($haipName, $ptr)
	{
		return self::_getSoapClient(array_merge(array($haipName, $ptr), array('__method' => 'setPtrForHaip')))->setPtrForHaip($haipName, $ptr);
	}

	/**
	 * Update the description for HA-IP
	 *
	 * @param string $haipName 
	 * @param string $description 
	 * @throws ApiException
	 */
	public static function setHaipDescription($haipName, $description)
	{
		return self::_getSoapClient(array_merge(array($haipName, $description), array('__method' => 'setHaipDescription')))->setHaipDescription($haipName, $description);
	}

	/**
	 * Get all port configurations for given HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @deprecated Please use HaipService::getPortConfigurations()
	 * @throws ApiException
	 * @return array 
	 */
	public static function getHaipPortConfigurations($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getHaipPortConfigurations')))->getHaipPortConfigurations($haipName);
	}

	/**
	 * Get all port configurations for given HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @throws ApiException
	 * @return array 
	 */
	public static function getPortConfigurations($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'getPortConfigurations')))->getPortConfigurations($haipName);
	}

	/**
	 * Set default port configurations for given HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @throws ApiException
	 */
	public static function setDefaultPortConfiguration($haipName)
	{
		return self::_getSoapClient(array_merge(array($haipName), array('__method' => 'setDefaultPortConfiguration')))->setDefaultPortConfiguration($haipName);
	}

	/**
	 * Add port configuration to HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @param string $name The name describing the port configuration
	 * @param int $portNumber The port that is addressed on the HA-IP IP
	 * @param string $mode The port mode ('tcp','http','https','proxy')
	 * @deprecated Please use HaipService::addPortConfiguration()
	 * @throws ApiException
	 */
	public static function addHaipPortConfiguration($haipName, $name, $portNumber, $mode)
	{
		return self::_getSoapClient(array_merge(array($haipName, $name, $portNumber, $mode), array('__method' => 'addHaipPortConfiguration')))->addHaipPortConfiguration($haipName, $name, $portNumber, $mode);
	}

	/**
	 * Add port configuration to HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @param string $name The name describing the port configuration
	 * @param int $sourcePort The port that is addressed on the HA-IP IP
	 * @param int $targetPort The port that is addressed on the VPS
	 * @param string $mode The port mode ('tcp','http','https','proxy')
	 * @param string $endpointSslMode The SSL mode for the endpoint ('off','on','strict')
	 * @throws ApiException
	 */
	public static function addPortConfiguration($haipName, $name, $sourcePort, $targetPort, $mode, $endpointSslMode)
	{
		return self::_getSoapClient(array_merge(array($haipName, $name, $sourcePort, $targetPort, $mode, $endpointSslMode), array('__method' => 'addPortConfiguration')))->addPortConfiguration($haipName, $name, $sourcePort, $targetPort, $mode, $endpointSslMode);
	}

	/**
	 * Update port configuration to HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @param int $configurationId The identifier for the configuration
	 * @param string $name The name describing the port configuration
	 * @param int $portNumber The port that is addressed on the HA-IP IP
	 * @param string $mode The port mode ('tcp','http','https','proxy')
	 * @deprecated Please use HaipService::updatePortConfiguration()
	 * @throws ApiException
	 */
	public static function updateHaipPortConfiguration($haipName, $configurationId, $name, $portNumber, $mode)
	{
		return self::_getSoapClient(array_merge(array($haipName, $configurationId, $name, $portNumber, $mode), array('__method' => 'updateHaipPortConfiguration')))->updateHaipPortConfiguration($haipName, $configurationId, $name, $portNumber, $mode);
	}

	/**
	 * Update port configuration to HA-IP
	 *
	 * @param string $haipName The HA-IP name
	 * @param int $configurationId The identifier for the configuration
	 * @param string $name The name describing the port configuration
	 * @param int $sourcePort The port that is addressed on the HA-IP IP
	 * @param int $targetPort The port that is addressed on the VPS
	 * @param string $mode The port mode ('tcp','http','https','proxy')
	 * @param string $endpointSslMode The SSL mode for the endpoint ('off','on','strict')
	 * @throws ApiException
	 */
	public static function updatePortConfiguration($haipName, $configurationId, $name, $sourcePort, $targetPort, $mode, $endpointSslMode)
	{
		return self::_getSoapClient(array_merge(array($haipName, $configurationId, $name, $sourcePort, $targetPort, $mode, $endpointSslMode), array('__method' => 'updatePortConfiguration')))->updatePortConfiguration($haipName, $configurationId, $name, $sourcePort, $targetPort, $mode, $endpointSslMode);
	}

	/**
	 * Delete configuration with the provided id from the HA-IP.
	 *
	 * @param string $haipName The HA-IP name
	 * @param int $configurationId The identifier for the configuration
	 * @deprecated Please use HaipService::deletePortConfiguration()
	 * @throws ApiException
	 */
	public static function deleteHaipPortConfiguration($haipName, $configurationId)
	{
		return self::_getSoapClient(array_merge(array($haipName, $configurationId), array('__method' => 'deleteHaipPortConfiguration')))->deleteHaipPortConfiguration($haipName, $configurationId);
	}

	/**
	 * 
	 *
	 * @param string $haipName 
	 * @param int $configurationId 
	 * @throws ApiException
	 */
	public static function deletePortConfiguration($haipName, $configurationId)
	{
		return self::_getSoapClient(array_merge(array($haipName, $configurationId), array('__method' => 'deletePortConfiguration')))->deletePortConfiguration($haipName, $configurationId);
	}

	/**
	 * Cancel a Haip
	 *
	 * @param string $haipName The vps to cancel
	 * @param string $endTime The time to cancel the haip (HaipService::CANCELLATIONTIME_END (end of contract)
	 * @throws ApiException on error
	 */
	public static function cancelHaip($haipName, $endTime)
	{
		return self::_getSoapClient(array_merge(array($haipName, $endTime), array('__method' => 'cancelHaip')))->cancelHaip($haipName, $endTime);
	}
}

?>
