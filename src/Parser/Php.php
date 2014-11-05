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

use Exception;

/**
 * Allows plain php templates to be parsed
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class Php extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	public function parse($file, array $data = [])
	{
		$obCleanRoom = function ($__file, $__data)
		{
			extract($__data, EXTR_REFS);
			ob_start();

			try
			{
				// Load the view within the current scope
				include $__file;
			}
			catch (Exception $exception)
			{
				// Delete the output buffer
				ob_end_clean();

				// Re-throw the exception
				throw $exception;
			}

			// Get the captured output and close the buffer
			return ob_get_clean();
		};

		return $obCleanRoom($file, $data);
	}
}
