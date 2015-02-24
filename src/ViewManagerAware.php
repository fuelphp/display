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
 * Accepts a ViewManager instance
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
interface ViewManagerAware
{
	/**
	 * Returns the ViewManager
	 *
	 * @return ViewManager
	 */
	public function getViewManager();

	/**
	 * Sets the ViewManager
	 *
	 * @param ViewManager $viewManager
	 */
	public function setViewManager(ViewManager $viewManager);
}
