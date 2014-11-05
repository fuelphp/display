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

use Fuel\Display\ViewManager;

/**
 * Common logic for custom loaders
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
abstract class AbstractLoader
{
	/**
	 * @var ViewManager
	 */
	protected $manager;

	/**
	 * @param ViewManager $manager
	 *
	 * @since 2.0
	 */
	public function __construct(ViewManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Locates a view file
	 *
	 * @param string $name
	 *
	 * @return string|null Path to file
	 */
	public function findView($name)
	{
		if (file_exists($name))
		{
			return $name;
		}

		return $this->manager->findView($name);
	}
}