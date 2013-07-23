<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Parser;

use Mustache_Loader;
use Mustache_Exception_UnknownTemplateException;
use Fuel\Presenter\ViewManager;

class MustacheLoader implements Mustache_Loader
{
	/**
	 * @var  \Fuel\Presenter\ViewManager  $manager
	 */
	protected $manager;

	/**
	 * Constructor
	 *
	 * $param  \Fuel\Presenter\ViewManager  $manager
	 */
	public function __construct(ViewManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Find a mustache file
	 *
	 * @param   string  $name  file name
	 * @return  string  pathe to file
	 * @throws  \Mustache_Exception_UnknownTemplateException  when the template isn't found
	 */
	public function findView($name)
	{
		if (substr($name, -9) !== '.mustache')
		{
			$name .= '.mustache';
		}

		if (file_exists($name))
		{
			return $name;
		}

		if ( ! $file = $this->manager->findView($name))
		{
			throw new Mustache_Exception_UnknownTemplateException('Could not locate: '.$name);
		}

		return $file;
	}

	/**
	 * Load a Template by name.
	 *
	 * @throws Mustache_Exception_UnknownTemplateException If a template file is not found.
	 * @param string $name
	 * @return string Mustache Template source
	 */
	public function load($name)
	{
		$file = $this->findView($name);

		return file_get_contents($file);
	}
}
