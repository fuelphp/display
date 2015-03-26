<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display;

/**
 * Can be implemented by classes that provide internal data sanitation logic
 */
interface Sanitize
{
	/**
	 * Sanitizes the object
	 *
	 * @return mixed
	 */
	public function sanitize();
}
