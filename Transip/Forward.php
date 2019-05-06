<?php

/**
 * This class models a ForwardHost
 *
 * @package Transip
 * @class Forward
 * @author TransIP (support@transip.nl)
 */
class Transip_Forward
{
	const FORWARDMETHOD_DIRECT = 'direct';
	const FORWARDMETHOD_FRAME = 'frame';

	/**
	 * Domain name to forward
	 *
	 * @var string
	 */
	public $domainName;

	/**
	 * URL to forward to
	 *
	 * @var string
	 */
	public $forwardTo;

	/**
	 * Method of forwarding; either Forward::FORWARDMETHOD_DIRECT or Forward::FORWARDMETHOD_FRAME
	 *
	 * @var string
	 */
	public $forwardMethod;

	/**
	 * Frame title if forwardMethod is set to Forward::FORWARDMETHOD_FRAME
	 *
	 * @var string
	 */
	public $frameTitle;

	/**
	 * Frame favicon if forwardMethod is set to Forward::FORWARDMETHOD_FRAME
	 *
	 * @var string
	 */
	public $frameIcon;

	/**
	 * Set to true to forward to preserve the URL info after the domain.
	 * For example, if set to true, http://www.sourcedomain.tld/test will
	 * be forwarded to http://www.targeturl.tld/test
	 *
	 * @var boolean
	 */
	public $forwardEverything;

	/**
	 * Set to true if subdomains should be appended to the target URL.
	 * For example, if set to true, http://test.sourcedomain.tld/ will
	 * be forwarded to http://www.targeturl.tld/test
	 *
	 * @var boolean
	 */
	public $forwardSubdomains;

	/**
	 * The e-mailaddress all emails to this forward are forwarded to.
	 * If empty, no e-mails are forwarded.
	 *
	 * @var string
	 */
	public $forwardEmailTo;

	/**
	 * Constructs a Forward object.
	 *
	 * @param string $domainName Domain name to forward
	 * @param string $forwardTo URL to forward to
	 * @param string $forwardMethod OPTIONAL Method of forwarding; either Forward::FORWARDMETHOD_DIRECT or Forward::FORWARDMETHOD_FRAME
	 * @param string $frameTitle OPTIONAL Frame title if forwardMethod is set to Forward::FORWARDMETHOD_FRAME
	 * @param string $frameIcon OPTIONAL Frame favicon if forwardMethod is set to Forward::FORWARDMETHOD_FRAME
	 * @param boolean $forwardEverything OPTIONAL Set to true to forward to preserve the URL info after the domain.
	 * @param boolean $forwardSubdomains OPTIONAL Set to true if subdomains should be appended to the target URL.
	 * @param string $forwardEmailTo OPTIONAL The e-mailaddress all emails to this forward are forwarded to.
	 */
    public function __construct($domainName, $forwardTo, $forwardMethod = 'direct', $frameTitle = '', $frameIcon = '', $forwardEverything = true, $forwardSubdomains = false, $forwardEmailTo = '')
    {
        $this->domainName = $domainName;
        $this->forwardTo = $forwardTo;
        $this->forwardMethod = $forwardMethod;
        $this->frameTitle = $frameTitle;
        $this->frameIcon = $frameIcon;
        $this->forwardEverything = $forwardEverything;
        $this->forwardSubdomains = $forwardSubdomains;
        $this->forwardEmailTo = $forwardEmailTo;
    }
}

?>
