<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Providers;

use Fuel\FileSystem\Finder;
use Fuel\Dependency\ServiceProvider;

/**
 * FuelPHP ServiceProvider class for this package
 *
 * @package Fuel\Display
 *
 * @since 2.0.0
 */
class FuelServiceProvider extends ServiceProvider
{
	/**
	 * @var array list of service names provided by this provider
	 */
	public $provides = [
		'viewmanager',
		'parser.php',
		'parser.markdown',
		'parser.mustache',
		'parser.twig',
		'parser.smarty',
		'parser.handlebars',
		'parser.hbs',
	];

	/**
	 * Service provider definitions
	 */
	public function provide()
	{
		// \Fuel\Display\ViewManager
		$this->register('viewmanager', function ($dic, Finder $finder, array $config = [])
		{
			return $dic->resolve('Fuel\Display\ViewManager', [$finder, $config]);
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
		$this->register('parser.twig', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\TwigLoader');
		});

		// \Fuel\Display\Parser\Smarty
		$this->register('parser.smarty', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Smarty');
		});

		// \Fuel\Display\Parser\Handlebars
		$this->register('parser.handlebars', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Handlebars');
		});

		// \Fuel\Display\Parser\Handlebars - alternate .hbs
		$this->register('parser.hbs', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Handlebars');
		});
	}
}
