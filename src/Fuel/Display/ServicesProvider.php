<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display;

use Fuel\Dependency\ServiceProvider;
use Fuel\FileSystem\Finder;

/**
 * ServicesProvider class
 *
 * Defines the services published by this namespace to the DiC
 *
 * @package  Fuel\Display
 *
 * @since  1.0.0
 */
class ServicesProvider extends ServiceProvider
{
	/**
	 * @var  array  list of service names provided by this provider
	 */
	public $provides = array('view', 'parser.php');

	/**
	 * Service provider definitions
	 */
	public function provide()
	{
		// \Fuel\Display\ViewManager
		$this->register('view', function ($dic, Finder $finder, array $config = array())
		{
			return new ViewManager($finder, $config);
		});

		// \Fuel\Display\Parser\Php
		$this->register('parser.php', function ($dic)
		{
			return new Parser\Php();
		});
	}
}
