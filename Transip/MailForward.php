<?php

/**
 * This class models a mailforward
 *
 * @package Transip
 * @class MailForward
 * @author TransIP (support@transip.nl)
 */
class Transip_MailForward
{
	/**
	 * The Mail address to forward to another address
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Where to forward mail to
	 *
	 * @var string
	 */
	public $targetAddress;

	/**
	 * Create a MailForward
	 *
	 * @param string $name Name of the MailForward
	 * @param string $targetAddress Where to forward to
	 */
    public function __construct($name, $targetAddress)
    {
        $this->name = $name;
        $this->targetAddress = $targetAddress;
    }
}

?>
