<?php

/**
 * This class holds the settings for the TransIP API.
 * 
 * @package Transip
 * @class ApiSettings
 * @author TransIP (support@transip.nl)
 */
class Transip_ApiSettings
{
	/**
	 * The mode in which the API operates, can be either:
	 *		readonly
	 *		readwrite
	 *
	 * In readonly mode, no modifying functions can be called.
	 * To make persistent changes, readwrite mode should be enabled.
	 */
	public static $mode = 'readwrite';

	 /**
	 * TransIP API endpoint to connect to.
	 *
	 * e.g.:
	 *
	 * 		'api.transip.nl'
	 * 		'api.transip.be'
	 * 		'api.transip.eu'
	 */
	public static $endpoint = 'api.transip.nl';

	/**
	 * Your login name on the TransIP website.
	 *
	 */
	public static $login = '';

	/**
	 * One of your private keys; these can be requested via your Controlpanel
	 */
	public static $privateKey = '';
}