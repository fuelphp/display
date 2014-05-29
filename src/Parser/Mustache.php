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

use Mustache_Engine;

/**
 * Allows views to be rendered from Mustache templates.
 *
 * @package Fuel\Display\Parser
 *
 * @since 2.0
 */
class Mustache extends AbstractParser
{

	/**
	 * @var Mustache_Engine $mustache
	 */
	protected $mustache;

	/**
	 * @param Mustache_Engine $mustache
	 *
	 * @since 2.0
	 */
	public function __construct(Mustache_Engine $mustache = null)
	{
		$this->mustache = $mustache;
	}

	/**
	 * Bootstrap Mustache_Engine
	 *
	 * @return Mustache_Engine
	 *
	 * @since 2.0
	 */
	public function setupMustache()
	{
		$mustacheLoader = new MustacheLoader($this->manager);
		$config = array('loader' => $mustacheLoader);

		if ($this->manager->cachePath)
		{
			$config['cache'] = $this->manager->cachePath.'mustache/';
		}

		return new Mustache_Engine($config);
	}

	/**
	 * Retrieve the Mustache_Engine
	 *
	 * @return Mustache_Engine
	 *
	 * @since 2.0
	 */
	public function getMustache()
	{
		if ( ! $this->mustache)
		{
			$this->mustache = $this->setupMustache();
		}

		return $this->mustache;
	}

	/**
	 * Parse the view
	 *
	 * @param string $file Path to view file
	 * @param array  $data View data
	 *
	 * @return string Parsed view
	 *
	 * @since 2.0
	 */
	public function parse($file, array $data)
	{
		$mustache = $this->getMustache();

		return $mustache->render($file, $data);
	}

}
