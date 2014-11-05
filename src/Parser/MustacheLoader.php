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

use Mustache_Loader;
use Mustache_Exception_UnknownTemplateException;
use Fuel\Display\ViewManager;

/**
 * Custom Mustache loader
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class MustacheLoader extends AbstractLoader implements Mustache_Loader
{
	/**
	 * {@inheritdoc}
	 *
	 * @throws Mustache_Exception_UnknownTemplateException If the template is not found
	 */
	public function findView($name)
	{
		if (substr($name, -9) !== '.mustache')
		{
			$name .= '.mustache';
		}

		if ( ! $file = parent::findView($name))
		{
			throw new Mustache_Exception_UnknownTemplateException('Could not locate: '.$name);
		}

		return $file;
	}

	/**
	 * {@inheritdoc}
	 */
	public function load($name)
	{
		$file = $this->findView($name);

		return file_get_contents($file);
	}
}
