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

use Twig_Error_Loader;
use Twig_LoaderInterface;
use Fuel\Display\ViewManager;

class TwigLoader implements Twig_LoaderInterface
{
	/**
	 * @var  \Fuel\Display\ViewManager  $manager
	 */
	protected $manager;

	/**
	 * Constructor
	 *
	 * @param  \Fuel\Display\ViewManager  $manager
	 */
	public function __construct(ViewManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Locate a view file
	 *
	 * @param   string  $name
	 * @return  string  path to file
	 * @throws  \Twig_Error_Loader when the view is not found
	 */
	public function findView($name)
	{
		if (substr($name, -5) !== '.twig')
		{
			$name .= '.twig';
		}

		if (file_exists($name))
		{
			return $name;
		}

		if ( ! $file = $this->manager->findView($name))
		{
			throw new Twig_Error_Loader('Could not locate: '.$name);
		}

		return $file;
	}

	/**
	 * Gets the source code of a template, given its name.
	 *
	 * @param string $name The name of the template to load
	 * @return string The template source code
	 * @throws Twig_Error_Loader When $name is not found
	 */
	public function getSource($name)
	{
		$file = $this->findView($name);

		return file_get_contents($file);
	}

	/**
	 * Gets the cache key to use for the cache for a given template name.
	 *
	 * @param string $name The name of the template to load
	 * @return string The cache key
	 * @throws Twig_Error_Loader When $name is not found
	 */
	public function getCacheKey($name)
	{
		return $this->findView($name);
	}

	/**
	 * Returns true if the template is still fresh.
	 *
	 * @param string    $name The template name
	 * @param timestamp $time The last modification time of the cached template
	 * @return Boolean true if the template is fresh, false otherwise
	 * @throws Twig_Error_Loader When $name is not found
	 */
	public function isFresh($name, $time)
	{
		$file = $this->findView($name);

		return filemtime($file) >= $time;
	}
}
