<?php

/**
 * This class models a mailbox
 *
 * @package Transip
 * @class MailBox
 * @author TransIP (support@transip.nl)
 */
class Transip_MailBox
{
	const SPAMCHECKER_STRENGTH_AVERAGE = 'AVERAGE';
	const SPAMCHECKER_STRENGTH_OFF = 'OFF';
	const SPAMCHECKER_STRENGTH_LOW = 'LOW';
	const SPAMCHECKER_STRENGTH_HIGH = 'HIGH';

	/**
	 * Address of this mailbox
	 *
	 * @var string
	 */
	public $address;

	/**
	 * Mailbox spamchecker level. One of the Transip_MailBox::SPAMCHECKER_STRENGTH_* constants.
	 *
	 * @var string
	 */
	public $spamCheckerStrength;

	/**
	 * Mailbox max size in MB
	 *
	 * @var int
	 */
	public $maxDiskUsage;

	/**
	 * True iff the MailBox currently has a VacationReply installed
	 *
	 * @var boolean
	 */
	public $hasVacationReply;

	/**
	 * VacationReply subject, used only when hasVacationReply is true
	 *
	 * @var string
	 */
	public $vacationReplySubject;

	/**
	 * VacationReply message, used only when hasVacationReply is true
	 *
	 * @var string
	 */
	public $vacationReplyMessage;

	/**
	 * Create new mailbox
	 *
	 * @param string $address the address of this MailBox
	 * @param string $spamCheckerStrength One of the Transip_MailBox::SPAMCHECKER_STRENGTH_* constants.
	 * @param int $maxDiskUsage max mailbox size in megabytes
	 * @param boolean $hasVacationReply does MailBox has vacationreply
	 * @param string $vacationReplySubject Subject of vacation reply
	 * @param string $vacationReplyMessage Message of vacation reply
	 */
    public function __construct($address, $spamCheckerStrength = 'AVERAGE', $maxDiskUsage = 20, $hasVacationReply = false, $vacationReplySubject = '', $vacationReplyMessage = '')
    {
        $this->address = $address;
        $this->spamCheckerStrength = $spamCheckerStrength;
        $this->maxDiskUsage = $maxDiskUsage;
        $this->hasVacationReply = $hasVacationReply;
        $this->vacationReplySubject = $vacationReplySubject;
        $this->vacationReplyMessage = $vacationReplyMessage;
    }
}

?>
