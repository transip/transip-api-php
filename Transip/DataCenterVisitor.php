<?php

/**
 * This class models a Visitor to the Datacenter. Currently being returned
 * by ColoService::requestAccess() in an array of all visitors that are granted access.
 *
 * @package Transip
 * @class DataCenterVisitor
 * @author TransIP (support@transip.nl)
 */
class Transip_DataCenterVisitor
{
	/**
	 * The name of the visitor
	 *
	 * @var string
	 */
	public $name;

	/**
	 * The reservation number of the visitor.
	 *
	 * @var string
	 */
	public $reservationNumber;

	/**
	 * The accesscode of the visitor.
	 *
	 * @var string
	 */
	public $accessCode;

	/**
	 * true iff this visitor been registered before at the datacenter. if true, does not need the accesscode
	 *
	 * @var boolean
	 */
	public $hasBeenRegisteredBefore;
}

?>
