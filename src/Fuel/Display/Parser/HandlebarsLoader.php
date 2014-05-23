<?php


namespace Fuel\Display\Parser;

use Fuel\Display\ViewManager;
use Fuel\Display\ViewNotFoundException;
use Handlebars\Loader;

class HandlebarsLoader implements Loader
{

	/**
	 * Prefix to append to file names when loading files
	 *
	 * @var string
	 */
	protected $prefix = '';

	/**
	 * @var ViewManager
	 */
	protected $manager;

	public function __construct(ViewManager $viewManager)
	{
		$this->manager = $viewManager;
	}

	/**
	 * Load a Template by name.
	 *
	 * @param string $name template name to load
	 *
	 * @return String
	 */
	public function load($name)
	{
		if (substr($name, -11) !== '.handlebars')
		{
			$name = $this->prefix . $name . '.handlebars';
		}

		$file = $name;

		if ( ! file_exists($name) && ! $file = $this->manager->findView($name))
		{
			throw new ViewNotFoundException($name);
		}

		$content  = file_get_contents($file);

		return $content;
	}

	/**
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * @param string $prefix
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

}
