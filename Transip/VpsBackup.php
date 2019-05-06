<?php

/**
 * This class models a vps backup
 *
 * @package Transip
 * @class VpsBackup
 * @author TransIP (support@transip.nl)
 */
class Transip_VpsBackup
{
	/**
	 * The backup id
	 *
	 * @var int
	 */
	public $id = 0;

	/**
	 * The backup creation date
	 *
	 * @var string
	 */
	public $dateTimeCreate = '';

	/**
	 * The backup disk size
	 *
	 * @var int
	 */
	public $diskSize = 0;

	/**
	 * The backup operatingSystem
	 *
	 * @var string
	 */
	public $operatingSystem = '';

	/**
	 * The name of the availability zone the backup is in
	 *
	 * @var string
	 */
	public $availabilityZone;
}

?>
