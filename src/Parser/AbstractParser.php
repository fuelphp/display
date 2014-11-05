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

use Fuel\Display\DataContainer;
use Fuel\Display\ViewManager;

/**
 * Manager logic for parsers
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
abstract class AbstractParser
{
	/**
	 * @var ViewManager
	 */
	protected $manager;

	/**
	 * Sets the view manager
	 *
	 * @param ViewManager $manager
	 *
	 * @return $this
	 */
	public function setManager(ViewManager $manager)
	{
		$this->manager = $manager;

		return $this;
	}

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
