<?php

/**
 * This class models a Product
 *
 * @package Transip
 * @class Product
 * @author TransIP (support@transip.nl)
 */
class Transip_Product
{
	/**
	 * Name of the product
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Describes this product
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Price in euros.
	 *
	 * @var float
	 */
	public $price;

	/**
	 * Price for renewing the product in euros.
	 *
	 * @var float
	 */
	public $renewalPrice;
}

?>
