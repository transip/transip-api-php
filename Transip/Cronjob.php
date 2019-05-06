<?php

/**
 * This class models a cronjob
 * that will be run on the Webhosting package for a domain name.
 *
 * @package Transip
 * @class Cronjob
 * @author TransIP (support@transip.nl)
 */
class Transip_Cronjob
{
	/**
	 * Cronjob name, a user defined name for this cronjob
	 *
	 * @var string
	 */
	public $name;

	/**
	 * URL this url will be called when the cronjob executes.
	 * Must be a valid (subdomain) within the current webhosting package's
	 * domain name.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Any output of this cronjob will be e-mailed to this email-address
	 *
	 * @var string
	 */
	public $email;

	/**
	 * What minute of the hour to run the cron
	 *
	 * @see http://en.wikipedia.org/wiki/Cron
	 * @var string
	 */
	public $minuteTrigger;

	/**
	 * What hour of the day to run the cron
	 *
	 * @see http://en.wikipedia.org/wiki/Cron
	 * @var string
	 */
	public $hourTrigger;

	/**
	 * What day of the month to run the cron
	 *
	 * @see http://en.wikipedia.org/wiki/Cron
	 * @var string
	 */
	public $dayTrigger;

	/**
	 * what month of the year to run the cron
	 *
	 * @see http://en.wikipedia.org/wiki/Cron
	 * @var string
	 */
	public $monthTrigger;

	/**
	 * what day of the week to run the cron
	 * range: 0-7 where both 0 and 7 are Sunday
	 *
	 * @see http://en.wikipedia.org/wiki/Cron
	 * @var string
	 */
	public $weekdayTrigger;

	/**
	 * Create a new cronjob
	 *
	 * @param string $name Cronjob name
	 * @param string $url Cronjob url to fetch
	 * @param string $email Mail address to send cron output to
	 * @param string $minuteTrigger Minute field for cronjob
	 * @param string $hourTrigger Hour field for cronjob
	 * @param string $dayTrigger Day field for cronjob
	 * @param string $monthTrigger Month field for cronjob
	 * @param string $weekdayTrigger Weekday field for cronjob
	 */
    public function __construct($name, $url, $email, $minuteTrigger, $hourTrigger, $dayTrigger, $monthTrigger, $weekdayTrigger)
    {
        $this->name = $name;
        $this->url = $url;
        $this->email = $email;
        $this->minuteTrigger = $minuteTrigger;
        $this->hourTrigger = $hourTrigger;
        $this->dayTrigger = $dayTrigger;
        $this->monthTrigger = $monthTrigger;
        $this->weekdayTrigger = $weekdayTrigger;
    }
}

?>
