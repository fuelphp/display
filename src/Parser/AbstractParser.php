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

abstract class AbstractParser extends DataContainer
{
	/**
	 * @var  \Fuel\Display\ViewManager  $manager
	 */
	protected $manager;

	/**
	 * Set the view manager
	 *
	 * @param   \Fuel\Display\ViewManager  $manager
	 * @return  $this
	 */
	public function setManager(ViewManager $manager)
	{
		$this->manager = $manager;

		return $this;
	}

	/**
	 * Parse the view
	 *
	 * @param   string  $file  path to view file
	 * @param   array   $data  view data
	 * @return  string  parsed view
	 */
	abstract public function parse($file, array $data);
}
