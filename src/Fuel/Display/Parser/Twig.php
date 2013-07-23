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

use Twig_Environment;

class Twig extends AbstractParser
{
	protected $twig;

	/**
	 * Constructor
	 *
	 * @param \Twig_Environment  $twig
	 */
	public function __construct(Twig_Environment $twig = null)
	{
		$this->twig = $twig;
	}

	/**
	 * Setup the twig ennvironment
	 *
	 * @return  \Twig_Environment
	 */
	public function setupTwig()
	{
		$twigLoader = new TwigLoader($this->manager);
		$config = array();

		if ($this->manager->cachePath) {
			$config['cache'] = $this->manager->cachePath.'twig/';
		}

		return new Twig_Environment($twigLoader, $config);
	}

	/**
	 * Retrieve the twig ennvironment
	 *
	 * @return  \Twig_Environment
	 */
	public function getTwig()
	{
		if ( ! $this->twig)
		{
			$this->twig = $this->setupTwig();
		}

		return $this->twig;
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
		$twig = $this->getTwig();

		return $twig->render($file, $data);
	}
}
