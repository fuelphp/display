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
	public $provides = array('viewmanager', 'parser.php', 'parser.markdown', 'parser.mustache', 'parser.twig', 'parser.smarty');

	/**
	 * Service provider definitions
	 */
	public function provide()
	{
		// \Fuel\Display\ViewManager
		$this->register('viewmanager', function ($dic, Finder $finder, array $config = array())
		{
			return new ViewManager($finder, $config);
		});

		// \Fuel\Display\Parser\Php
		$this->register('parser.php', function ($dic)
		{
			return new Parser\Php();
		});

		// \Fuel\Display\Parser\Markdown
		$this->register('parser.markdown', function ($dic)
		{
			return new Parser\Markdown();
		});
		// \Fuel\Display\Parser\Mustache
		$this->register('parser.mustache', function ($dic)
		{
			return new Parser\MustacheLoader();
		});

		// \Fuel\Display\Parser\Twig
		$this->register('parser.tiwg', function ($dic)
		{
			return new Parser\TwigLoader();
		});

		// \Fuel\Display\Parser\Smarty
		$this->register('parser.smarty', function ($dic)
		{
			return new Parser\Smarty();
		});
	}
}
