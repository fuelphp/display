<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display;

/**
 * Can be implemented by classes that provide internal data sanitation logic
 *
 * @package Fuel\Display
 *
 * @since 1.7
 */
interface Sanitize
{
	public function sanitizeObject();
}
