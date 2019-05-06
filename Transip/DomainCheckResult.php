<?php

/**
 * This class holds the data for one result item of a multi availability check.
 *
 * @package Transip
 * @class DomainCheckResult
 * @author TransIP (support@transip.nl)
 */
class Transip_DomainCheckResult
{
	const STATUS_INYOURACCOUNT = 'inyouraccount';
	const STATUS_UNAVAILABLE = 'unavailable';
	const STATUS_NOTFREE = 'notfree';
	const STATUS_FREE = 'free';
	const STATUS_INTERNALPULL = 'internalpull';
	const STATUS_INTERNALPUSH = 'internalpush';
	const ACTION_REGISTER = 'register';
	const ACTION_TRANSFER = 'transfer';
	const ACTION_INTERNALPULL = 'internalpull';
	const ACTION_INTERNALPUSH = 'internalpush';

	/**
	 * The name of the Domain for which we have a status in this object. This needs to meet the requirements specified in <a href="https://tools.ietf.org/html/rfc952" target="_blanc">RFC 952</a>
	 *
	 * @var string;
	 */
	public $domainName;

	/**
	 * The status for this domain, one of the Transip_DomainService::AVAILABILITY_* constants.
	 *
	 * @var string
	 */
	public $status;

	/**
	 * List of available actions to perform on this domain
	 *
	 * @var string[]
	 */
	public $actions;
}

?>
