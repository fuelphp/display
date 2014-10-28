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

class Php extends AbstractParser
{
	/**
	 * Parse the view
	 *
	 * @param   string  $file  path to view file
	 * @param   array   $data  view data
	 * @return  string  parsed view
	 */
	public function parse($file, Array $data = null)
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

		return $obCleanRoom($file, $data ?: $this->getData());
	}
}
