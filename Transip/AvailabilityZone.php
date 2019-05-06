<?php

/**
 * This class models an Availability Zone
 *
 * @package Transip
 * @class AvailabilityZone
 * @author TransIP (support@transip.nl)
 */
class Transip_AvailabilityZone
{
	/**
	 * The name of the Availability Zone
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The country the Availability Zone is in
	 *
	 * @var string
	 */
	public $country;

	/**
	 * If this is true, this zone will be used as the default zone for vps orders and clones
	 *
	 * @var boolean
	 */
	public $isDefault;
}

?>
