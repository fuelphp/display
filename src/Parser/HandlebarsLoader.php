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

use Fuel\Display\ViewManager;
use Fuel\Display\ViewNotFoundException;
use Handlebars\Loader;

/**
 * Custom Handlebars loader
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class HandlebarsLoader extends AbstractLoader implements Loader
{
	/**
	 * Prefix to append to file names when loading files
	 *
	 * @var string
	 */
	protected $prefix = '';

	/**
	 * Returns the file name prefix
	 *
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * Sets the file name prefix
	 *
	 * @param string $prefix
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

	/**
	 * {@inheritdoc}
	 */
	public function findView($name)
	{
		if (substr($name, -11) !== '.handlebars' && substr($name, -4) !== '.hbs')
		{
			$name = $this->prefix . $name . '.handlebars';
		}

		if ( ! $file = parent::findView($name))
		{
			throw new ViewNotFoundException('Could not locate: '.$name);
		}

		return $file
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
