<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Parser;

use Fuel\Display\Parser;
use Fuel\Display\ViewManagerAware;
use Fuel\Display\ViewManagerAcceptor;

/**
 * Manager logic for parsers
 */
abstract class AbstractParser implements Parser, ViewManagerAware
{
	use ViewManagerAcceptor;
}
