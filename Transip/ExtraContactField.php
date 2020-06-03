<?php

/**
 * This class models a ExtraContactField
 *
 * @package Transip
 * @class ExtraContactField
 * @author TransIP (support@transip.nl)
 */
class Transip_ExtraContactField
{
	/**
	 * The name of the ExtraContactField
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * The value of the ExtraContactField
	 *
	 * @var string
	 */
	public $value = '';

	/**
	 * Constructs a new ExtraContactField
	 *
	 * @param string $name
	 * @param string $value
	 */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}

?>
