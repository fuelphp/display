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
use League\Container\ServiceProvider;

/**
 * Fuel ServiceProvider class for Display
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class FuelServiceProvider extends ServiceProvider
{
	/**
	 * @var array
	 */
	protected $provides = [
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
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->add('getViewManagerInstance', function()
		{
			$app = $this->container->get('getApplicationInstance');

			return $app->getViewManager();
		});

		$this->container->inflector('Fuel\Display\ViewManagerAware')
			->invokeMethod('setViewManager', ['getViewManagerInstance']);

		$this->container->add('viewmanager', function (Finder $finder, array $config = [])
		{
			return $this->container->get('Fuel\Display\ViewManager', [$finder, $config]);
		});

		$this->container->add('parser.php', 'Fuel\Display\Parser\Php');
		$this->container->add('parser.markdown', 'Fuel\Display\Parser\Markdown');
		$this->container->add('parser.mustache', 'Fuel\Display\Parser\Mustache');
		$this->container->add('parser.twig', 'Fuel\Display\Parser\Twig');
		$this->container->add('parser.smarty', 'Fuel\Display\Parser\Smarty');
		$this->container->add('parser.handlebars', 'Fuel\Display\Parser\Handlebars');
		$this->container->add('parser.hbs', 'Fuel\Display\Parser\Handlebars');
	}
}
