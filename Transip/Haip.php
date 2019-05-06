<?php

/**
 * This class models a Haip
 *
 * @package Transip
 * @class Haip
 * @author TransIP (support@transip.nl)
 */
class Transip_Haip
{
	/**
	 * HA-IP name.
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * HA-IP status.
	 *
	 * @var string
	 */
	public $status = '';

	/**
	 * If the HA-IP is blocked.
	 *
	 * @var boolean
	 */
	public $isBlocked = false;

	/**
	 * If load balancing is enabled for the HA-IP.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @var boolean
	 */
	public $isLoadBalancingEnabled = false;

	/**
	 * Load balancing mode that is configured for the HA-IP.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @var string
	 */
	public $loadBalancingMode = '';

	/**
	 * The cookie name that is used when the load balancing mode is set to 'cookie' HA-IP.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @var string
	 */
	public $stickyCookieName = '';

	/**
	 * The health check mode configured for the HA-IP.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @var string
	 */
	public $healthCheckMode = '';

	/**
	 * The HTTP path that will accessed for health checks when the health check mode is 'http'.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @var string
	 */
	public $httpHealthCheckPath = '';

	/**
	 * The port that will accessed for health checks when the health check mode is 'http'.
	 * 
	 * This is a HA-IP Pro feature.
	 *
	 * @var string
	 */
	public $httpHealthCheckPort = '';

	/**
	 * HA-IP IPv4 address.
	 *
	 * @var string
	 */
	public $ipv4Address = '';

	/**
	 * HA-IP IPv6 address.
	 *
	 * @var string
	 */
	public $ipv6Address = '';

	/**
	 * HA-IP IP setup.
	 *
	 * @var string
	 */
	public $ipSetup = '';

	/**
	 * An array of Vpses attached to the HA-IP.
	 *
	 * @var Transip_Vps[]
	 */
	public $attachedVpses = array();

	/**
	 * Name of Vps attached to the HA-IP.
	 *
	 * @deprecated Only shows data for one of the attached Vpses; use $attachedVpses instead.
	 * @var string
	 */
	public $vpsName = '';

	/**
	 * IPv4 address of Vps attached to the HA-IP.
	 *
	 * @deprecated Only shows data for one of the attached Vpses; use $attachedVpses instead.
	 * @var string
	 */
	public $vpsIpv4Address = '';

	/**
	 * IPv6 address of Vps attached to the HA-IP.
	 *
	 * @deprecated Only shows data for one of the attached Vpses; use $attachedVpses instead.
	 * @var string
	 */
	public $vpsIpv6Address = '';
}

?>
