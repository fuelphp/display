<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Providers;

use Fuel\FileSystem\Finder;

use Fuel\Dependency\ServiceProvider;

/**
 * FuelPHP ServiceProvider class for this package
 *
 * @package  Fuel\Display
 *
 * @since  1.0.0
 */
class FuelServiceProvider extends ServiceProvider
{
	/**
	 * @var  array  list of service names provided by this provider
	 */
	public $provides = array('viewmanager', 'parser.php', 'parser.markdown', 'parser.mustache', 'parser.twig', 'parser.smarty');

	/**
	 * Service provider definitions
	 */
	public function provide()
	{
		// \Fuel\Display\ViewManager
		$this->register('viewmanager', function ($dic, Finder $finder, array $config = array())
		{
			return $dic->resolve('Fuel\Display\ViewManager', array($finder, $config));
		});

		// \Fuel\Display\Parser\Php
		$this->register('parser.php', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Php');
		});

		// \Fuel\Display\Parser\Markdown
		$this->register('parser.markdown', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Markdown');
		});

		// \Fuel\Display\Parser\MustacheLoader
		$this->register('parser.mustache', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\MustacheLoader');
		});

		// \Fuel\Display\Parser\TwigLoader
		$this->register('parser.tiwg', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\TwigLoader');
		});

		// \Fuel\Display\Parser\Smarty
		$this->register('parser.smarty', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Smarty');
		});
	}
}
