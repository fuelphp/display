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

use Handlebars\Handlebars as HandlebarsEngine;

/**
 * Allows handlebars templates to be parsed
 *
 * @package Fuel\Display\Parser
 * @since   2.0
 */
class Handlebars extends AbstractParser
{

	/**
	 * @var HandlebarsEngine
	 */
	protected $engine;

	public function __construct($engine = null)
	{
		$this->engine = $engine;
	}

	protected function setupEngine()
	{
		$this->engine = new HandlebarsEngine();

		$loader = new HandlebarsLoader($this->manager);

		$partialLoader = new HandlebarsLoader($this->manager);
		$partialLoader->setPrefix('_');

		$this->engine->setLoader($loader);
		$this->engine->setPartialsLoader($partialLoader);
	}

	protected function getEngine()
	{
		if ($this->engine === null)
		{
			$this->setupEngine();
		}

		return $this->engine;
	}

	/**
	 * Parse the view
	 *
	 * @param string $file path to view file
	 * @param array  $data view data
	 *
	 * @return string parsed view
	 */
	public function parse($file, array $data = [])
	{
		return $this->getEngine()->render($file, $data);
	}

}
