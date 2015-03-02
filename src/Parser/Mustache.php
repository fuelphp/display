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

use Mustache_Engine;

/**
 * Allows Mustache templates to be parsed
 */
class Mustache extends AbstractParser
{
	/**
	 * @var Mustache_Engine $mustache
	 */
	protected $mustache;

	/**
	 * @param Mustache_Engine $mustache
	 */
	public function __construct(Mustache_Engine $mustache = null)
	{
		$this->mustache = $mustache;
	}

	/**
	 * Returns the Mustache_Engine
	 *
	 * @return Mustache_Engine
	 */
	public function getMustache()
	{
		if ($this->mustache === null)
		{
			$this->setupMustache();
		}

		return $this->mustache;
	}

	/**
	 * Sets up Mustache_Engine
	 */
	public function setupMustache()
	{
		$mustacheLoader = new MustacheLoader($this->viewManager);
		$config = ['loader' => $mustacheLoader];

		if ($this->viewManager->cachePath)
		{
			$config['cache'] = $this->viewManager->cachePath.'mustache/';
		}

		$this->mustache = new Mustache_Engine($config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse($file, array $data = [])
	{
		$mustache = $this->getMustache();

		return $mustache->render($file, $data);
	}

}
