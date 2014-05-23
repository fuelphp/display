<?php


namespace Fuel\Display\Parser;

use Fuel\Display\ViewManager;
use Fuel\Display\ViewNotFoundException;
use Handlebars\Loader;

class HandlebarsLoader implements Loader
{

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
			$name .= '.handlebars';
		}

		$file = $name;

		if ( ! file_exists($name))
		{
			//TODO: Cleanup
			if ( ! $file = $this->manager->findView($name))
			{
				throw new ViewNotFoundException($name);
			}
		}

		$content  = file_get_contents($file);

		return $content;
	}

}
