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

use dflydev\markdown\MarkdownExtraParser;

class MarkdownExtra extends AbstractParser
{
	/**
	 * Constructor
	 *
	 * @param  \dflydev\markdown\MarkdownExtraParser  $parser
	 */
	public function __construct(MarkdownExtraParser $parser = null)
	{
		$this->markdown = $parser ?: new MarkdownExtraParser;
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
		$contents = file_get_contents($file);

		return $this->markdown->transformMarkdown($contents);
	}
}
