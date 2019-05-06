<?php

/**
 * Models branding for a Domain
 *
 * @package Transip
 * @class DomainBranding
 * @author TransIP (support@transip.nl)
 */
class Transip_DomainBranding
{
	/**
	 * The company name displayed in transfer-branded e-mails
	 *
	 * @var string
	 */
	public $companyName;

	/**
	 * The support email used for transfer-branded e-mails
	 *
	 * @var string
	 */
	public $supportEmail;

	/**
	 * The company url displayed in transfer-branded e-mails
	 *
	 * @var string
	 */
	public $companyUrl;

	/**
	 * The terms of usage url as displayed in transfer-branded e-mails
	 *
	 * @var string
	 */
	public $termsOfUsageUrl;

	/**
	 * The first generic bannerLine displayed in whois-branded whois output.
	 *
	 * @var string
	 */
	public $bannerLine1;

	/**
	 * The second generic bannerLine displayed in whois-branded whois output.
	 *
	 * @var string
	 */
	public $bannerLine2;

	/**
	 * The third generic bannerLine displayed in whois-branded whois output.
	 *
	 * @var string
	 */
	public $bannerLine3;
}

?>
