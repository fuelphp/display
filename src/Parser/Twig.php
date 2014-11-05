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

use Twig_Environment;

/**
 * Allows Twig templates to be parsed
 *
 * @package Fuel\Display
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
	 * Returns the Twig Environment
	 *
	 * @return Twig_Environment
	 *
	 * @since 2.0
	 */
	public function getTwig()
	{
		if ($this->twig === null)
		{
			$this->setupTwig();
		}

		return $this->twig;
	}

	/**
	 * Setups the Twig Environment
	 *
	 * @since 2.0
	 */
	public function setupTwig()
	{
		$twigLoader = new TwigLoader($this->manager);
		$config = [];

		if ($this->manager->cachePath)
		{
			$config['cache'] = $this->manager->cachePath.'twig/';
		}

		$this->twig new Twig_Environment($twigLoader, $config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse($file, array $data = [])
	{
		$twig = $this->getTwig();

		return $twig->render($file, $data);
	}

}
