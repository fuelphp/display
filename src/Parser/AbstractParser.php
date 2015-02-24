<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Parser;

use Fuel\Display\ViewManagerAware;
use Fuel\Display\ViewManagerAcceptor;

/**
 * Manager logic for parsers
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
abstract class AbstractParser implements ViewManagerAware
{
	use ViewManagerAcceptor;

	/**
	 * Parses the view
	 *
	 * @param string $file
	 * @param array  $data
	 *
	 * @return string
	 */
	abstract public function parse($file, array $data = []);
}
