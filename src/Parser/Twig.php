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

use Twig_Environment;

/**
 * Allows Twig templates to be parsed
 */
class Twig extends AbstractParser
{
	/**
	 * @var Twig_Environment
	 */
	protected $twig;

	/**
	 * @param Twig_Environment $twig
	 */
	public function __construct(Twig_Environment $twig = null)
	{
		$this->twig = $twig;
	}

	/**
	 * Returns the Twig Environment
	 *
	 * @return Twig_Environment
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
	 * Sets the Twig Environment up
	 */
	public function setupTwig()
	{
		$twigLoader = new TwigLoader($this->manager);
		$config = [];

		if ($this->manager->cachePath)
		{
			$config['cache'] = $this->manager->cachePath.'twig/';
		}

		$this->twig = new Twig_Environment($twigLoader, $config);
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
