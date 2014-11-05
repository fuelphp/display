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

use Twig_Error_Loader;
use Twig_LoaderInterface;
use Fuel\Display\ViewManager;

/**
 * Custom Twig loader
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class TwigLoader extends AbstractLoader implements Twig_LoaderInterface
{
	/**
	 * {@inheritdoc}
	 *
	 * @throws Twig_Error_Loader If the view is not found
	 */
	public function findView($name)
	{
		if (substr($name, -5) !== '.twig')
		{
			$name .= '.twig';
		}

		if ( ! $file = parent::findView($name))
		{
			throw new Twig_Error_Loader('Could not locate: '.$name);
		}

		return $file;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSource($name)
	{
		$file = $this->findView($name);

		return file_get_contents($file);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCacheKey($name)
	{
		return $this->findView($name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function isFresh($name, $time)
	{
		$file = $this->findView($name);

		return filemtime($file) >= $time;
	}
}
