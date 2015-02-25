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

use Fuel\Display\ViewManager;

/**
 * Common logic for custom loaders
 */
abstract class AbstractLoader
{
	/**
	 * @var ViewManager
	 */
	protected $viewManager;

	/**
	 * @param ViewManager $viewManager
	 */
	public function __construct(ViewManager $viewManager)
	{
		$this->viewManager = $viewManager;
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

		return $this->viewManager->findView($name);
	}
}
