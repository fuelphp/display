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
 * Allows Handlebars templates to be parsed
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class Handlebars extends AbstractParser
{
	/**
	 * @var HandlebarsEngine
	 */
	protected $engine;

	/**
	 * @param HandlebarsEngine $engine
	 *
	 * @since 2.0
	 */
	public function __construct(HandlebarsEngine $engine = null)
	{
		$this->engine = $engine;
	}

	/**
	 * Returns the engine
	 *
	 * @return HandlebarsEngine
	 */
	public function getEngine()
	{
		if ($this->engine === null)
		{
			$this->setupEngine();
		}

		return $this->engine;
	}

	/**
	 * Sets up HandlebarsEngine
	 *
	 * @since 2.0
	 */
	protected function setupEngine()
	{
		$this->engine = new HandlebarsEngine;

		$loader = new HandlebarsLoader($this->manager);

		$partialLoader = new HandlebarsLoader($this->manager);
		$partialLoader->setPrefix('_');

		$this->engine->setLoader($loader);
		$this->engine->setPartialsLoader($partialLoader);
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse($file, array $data = [])
	{
		return $this->getEngine()->render($file, $data);
	}

}
