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
 * Accepts a ViewManager instance
 */
trait ViewManagerAcceptor
{
	/**
	 * @var ViewManager
	 */
	protected $viewManager;

	/**
	 * {@inheritdoc}
	 */
	public function getViewManager()
	{
		return $this->viewManager;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setViewManager(ViewManager $viewManager)
	{
		$this->viewManager = $viewManager;
	}
}
