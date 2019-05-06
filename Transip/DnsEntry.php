<?php

/**
 * Models A DnsEntry
 *
 * @package Transip
 * @class DnsEntry
 * @author TransIP (support@transip.nl)
 */
class Transip_DnsEntry
{
	const TYPE_A = 'A';
	const TYPE_AAAA = 'AAAA';
	const TYPE_CNAME = 'CNAME';
	const TYPE_MX = 'MX';
	const TYPE_NS = 'NS';
	const TYPE_TXT = 'TXT';
	const TYPE_SRV = 'SRV';

	/**
	 * The name of the dns entry, for example '@' or 'www'
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The expiration period of the dns entry, in seconds. For example 86400 for a day
	 * of expiration
	 *
	 * @var int
	 */
	public $expire;

	/**
	 * The type of dns entry, for example A, MX or CNAME
	 *
	 * @var string
	 */
	public $type;

	/**
	 * The content of of the dns entry, for example '10 mail', '127.0.0.1' or 'www'
	 *
	 * @var string
	 */
	public $content;

	/**
	 * Constructs a new DnsEntry of the form
	 * www    IN    86400    A        127.0.0.1
	 * mail IN    86400    CNAME    @
	 * 
	 * Note that the IN class is always mandatory for this Entry and this is implied.
	 *
	 * @param string $name the name of this DnsEntry, e.g. www, mail or @
	 * @param int $expire the expiration period of the dns entry, in seconds. For example 86400 for a day
	 * @param string $type the type of this entry, one of the TYPE_ constants in this class
	 * @param string $content content of of the dns entry, for example '10 mail', '127.0.0.1' or 'www'
	 */
    public function __construct($name, $expire, $type, $content)
    {
        $this->name = $name;
        $this->expire = $expire;
        $this->type = $type;
        $this->content = $content;
    }
}

?>
