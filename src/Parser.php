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
 * Parses a view file using templating engines
 */
interface Parser
{
	/**
	 * Parses the view
	 *
	 * @param string $file
	 * @param array  $data
	 *
	 * @return string
	 */
	public function parse($file, array $data = []);
}
