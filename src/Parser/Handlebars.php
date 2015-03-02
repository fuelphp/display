<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Parser;

use Handlebars\Handlebars as HandlebarsEngine;

/**
 * Allows Handlebars templates to be parsed
 */
class Handlebars extends AbstractParser
{
	/**
	 * @var HandlebarsEngine
	 */
	protected $engine;

	/**
	 * @param HandlebarsEngine $engine
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
	 * Sets HandlebarsEngine up
	 */
	protected function setupEngine()
	{
		$this->engine = new HandlebarsEngine;

		$loader = new HandlebarsLoader($this->viewManager);

		$partialLoader = new HandlebarsLoader($this->viewManager);
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
