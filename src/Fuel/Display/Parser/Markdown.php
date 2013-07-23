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

use dflydev\markdown\MarkdownParser;

class Markdown extends AbstractParser
{
	/**
	 * Constructor
	 *
	 * @param  \dflydev\markdown\MarkdownParser  $parser
	 */
	public function __construct(MarkdownParser $parser = null)
	{
		$this->markdown = $parser ?: new MarkdownParser;
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
