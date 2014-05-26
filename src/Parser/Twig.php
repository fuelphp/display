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

/**
 * Allows twig templates to be parsed as views
 *
 * @package Fuel\Display\Parser
 *
 * @since 2.0
 */
class Twig extends AbstractParser
{

	/**
	 * @var Twig_Environment
	 */
	protected $twig;

	/**
	 * @param Twig_Environment $twig
	 *
	 * @since 2.0
	 */
	public function __construct(Twig_Environment $twig = null)
	{
		$this->twig = $twig;
	}

	/**
	 * Setup the twig environment
	 *
	 * @return Twig_Environment
	 *
	 * @since 2.0
	 */
	public function setupTwig()
	{
		$twigLoader = new TwigLoader($this->manager);
		$config = array();

		if ($this->manager->cachePath)
		{
			$config['cache'] = $this->manager->cachePath.'twig/';
		}

		return new Twig_Environment($twigLoader, $config);
	}

	/**
	 * Retrieve the twig environment
	 *
	 * @return Twig_Environment
	 *
	 * @since 2.0
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
	 * @param string $file Path to view file
	 * @param array  $data View data
	 *
	 * @return string Parsed view
	 *
	 * @since 2.0
	 */
	public function parse($file, array $data)
	{
		$twig = $this->getTwig();

		return $twig->render($file, $data);
	}

}
