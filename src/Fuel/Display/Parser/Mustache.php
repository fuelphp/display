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

use Mustache_Engine;

class Mustache extends AbstractParser
{
	/**
	 * @var  \Mustache_Engine  $mustache
	 */
	protected $mustache;

	/**
	 * Constructor
	 *
	 * @param  \Mustache_Engine  $mustache
	 */
	public function __construct(Mustache_Engine $mustache = null)
	{
		$this->mustache = $mustache;
	}

	/**
	 * Bootstrap Mustache_Engine
	 *
	 * @return  \Mustache_Engine
	 */
	public function setupMustache()
	{
		$mustacheLoader = new MustacheLoader($this->manager);
		$config = array('loader' => $mustacheLoader);

		if ($this->manager->cachePath) {
			$config['cache'] = $this->manager->cachePath.'mustache/';
		}

		return new Mustache_Engine($config);
	}

	/**
	 * Retrieve the Mustache_Engine
	 *
	 * @return  \Mustache_Engine
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
	 * @param   string  $file  path to view file
	 * @param   array   $data  view data
	 * @return  string  parsed view
	 */
	public function parse($file, array $data)
	{
		$mustache = $this->getMustache();

		return $mustache->render($file, $data);
	}
}
