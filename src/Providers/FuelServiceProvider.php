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
		/**
		 * Define the generic extensions provided by this service provider
		 */
		$this->extension('getViewManagerInstance', function($container, $instance)
		{
			try
			{
				$stack = $container->resolve('requeststack');
				if ($request = $stack->top())
				{
					$app = $request->getComponent()->getApplication();
				}
				else
				{
					$app = $container->resolve('application::__main');
				}

				if (is_callable(array($instance, 'setViewManager')))
				{
					$instance->setViewManager($app->getViewManager());
				}
				elseif (is_callable(array($instance, 'setManager')))
				{
					$instance->setManager($app->getViewManager());
				}
				else
				{
					$instance->viewmanager = $app->getViewManager();
				}
			}
			catch (\Fuel\Dependency\ResolveException $e)
			{
				// ignore
			}
		});

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
		$this->extend('parser.php', 'getViewManagerInstance');

		// \Fuel\Display\Parser\Markdown
		$this->register('parser.markdown', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Markdown');
		});
		$this->extend('parser.markdown', 'getViewManagerInstance');

		// \Fuel\Display\Parser\Mustache
		$this->register('parser.mustache', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Mustache');
		});
		$this->extend('parser.mustache', 'getViewManagerInstance');

		// \Fuel\Display\Parser\Twig
		$this->register('parser.twig', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Twig');
		});
		$this->extend('parser.twig', 'getViewManagerInstance');

		// \Fuel\Display\Parser\Smarty
		$this->register('parser.smarty', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Smarty');
		});
		$this->extend('parser.smarty', 'getViewManagerInstance');

		// \Fuel\Display\Parser\Handlebars
		$this->register('parser.handlebars', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Handlebars');
		});
		$this->extend('parser.handlebars', 'getViewManagerInstance');

		// \Fuel\Display\Parser\Handlebars - alternate .hbs
		$this->register('parser.hbs', function ($dic)
		{
			return $dic->resolve('Fuel\Display\Parser\Handlebars');
		});
		$this->extend('parser.hbs', 'getViewManagerInstance');
	}
}
