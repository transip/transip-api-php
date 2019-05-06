<?php

/**
 * This class models a Tld and holds information such as price,
 * registration length and capabilities.
 *
 * @package Transip
 * @class Tld
 * @author TransIP (support@transip.nl)
 */
class Transip_Tld
{
	const CAPABILITY_REQUIRESAUTHCODE = 'requiresAuthCode';
	const CAPABILITY_CANREGISTER = 'canRegister';
	const CAPABILITY_CANTRANSFERWITHOWNERCHANGE = 'canTransferWithOwnerChange';
	const CAPABILITY_CANTRANSFERWITHOUTOWNERCHANGE = 'canTransferWithoutOwnerChange';
	const CAPABILITY_CANSETLOCK = 'canSetLock';
	const CAPABILITY_CANSETOWNER = 'canSetOwner';
	const CAPABILITY_CANSETCONTACTS = 'canSetContacts';
	const CAPABILITY_CANSETNAMESERVERS = 'canSetNameservers';

	/**
	 * The name of this TLD, including the starting dot. E.g. .nl or .com.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Price of the TLD in Euros
	 *
	 * @var float
	 */
	public $price;

	/**
	 * Price for renewing the TLD in Euros
	 *
	 * @var float
	 */
	public $renewalPrice;

	/**
	 * A list of the capabilities that this Tld has (the things that can be
	 * done with a domain under this tld).
	 * All capabilities are one of CAPABILITY_* constants.
	 *
	 * @var string[]
	 */
	public $capabilities;

	/**
	 * Length in months of each registration or renewal period.
	 *
	 * @var int
	 */
	public $registrationPeriodLength;

	/**
	 * Number of days a domain needs to be canceled before the renewal date.
	 * E.g., If the renewal date is 10-Dec-2011 and the cancelTimeFrame is 4 days,
	 * the domain has to be canceled before 6-Dec-2011, otherwise it will be
	 * renewed already.
	 *
	 * @var int
	 */
	public $cancelTimeFrame;
}

?>
