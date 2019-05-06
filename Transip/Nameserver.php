<?php

/**
 * Models A Nameserver
 *
 * @package Transip
 * @class Nameserver
 * @author TransIP (support@transip.nl)
 */
class Transip_Nameserver
{
	/**
	 * The hostname of this nameserver
	 *
	 * @var string
	 */
	public $hostname = '';

	/**
	 * Optional ipv4 glue record for this nameserver, leave
	 * empty when no ipv4 glue record is needed for this nameserver.
	 *
	 * @var string
	 */
	public $ipv4 = '';

	/**
	 * Optional ipv6 glue record for this nameserver, leave
	 * empty when no ipv6 glue record is needed for this nameserver.
	 *
	 * @var string
	 */
	public $ipv6 = '';

	/**
	 * Constructs a new Nameserver.
	 *
	 * @param string $hostname the hostname for this nameserver
	 * @param string $ipv4 OPTIONAL ipv4 glue record for this nameserver
	 * @param string $ipv6 OPTIONAL ipv6 glue record for this nameserver
	 */
    public function __construct($hostname, $ipv4 = '', $ipv6 = '')
    {
        $this->hostname = $hostname;
        $this->ipv4 = $ipv4;
        $this->ipv6 = $ipv6;
    }
}

?>
