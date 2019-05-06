<?php

/**
 * This class models a WebHost
 * 
 * Please be aware that this information is outdated when
 * A modifying function in Transip_WebhostingService is called (e.g. createCronjob()).
 * 
 * Refresh when needed with calling Transip_WebhostingService::getInfo() again
 *
 * @package Transip
 * @class WebHost
 * @author TransIP (support@transip.nl)
 */
class Transip_WebHost
{
	/**
	 * Domain name of the webhosting package
	 *
	 * @var string
	 */
	public $domainName;

	/**
	 * The list of active cronjobs for this webhosting package
	 *
	 * @var Transip_Cronjob[]
	 */
	public $cronjobs;

	/**
	 * The list of active Mailboxes for this webhosting package
	 *
	 * @var Transip_MailBox[]
	 */
	public $mailBoxes;

	/**
	 * The list of active Databases for this webhosting package
	 *
	 * @var Transip_Db[]
	 */
	public $dbs;

	/**
	 * The list of active mail aliases/forwards for this webhosting package
	 *
	 * @var Transip_MailForward[]
	 */
	public $mailForwards;

	/**
	 * The list of active subdomains for this webhosting package
	 *
	 * @var Transip_SubDomain[]
	 */
	public $subDomains;
}

?>
