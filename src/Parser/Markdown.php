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

use dflydev\markdown\MarkdownParser;

/**
 * Allows for the parsing of Markdown
 *
 * @package Fuel\Display\Parser
 *
 * @since 2.0
 */
class Markdown extends AbstractParser
{

	/**
	 * @var MarkdownParser
	 */
	protected $markdown;

	/**
	 * @param MarkdownParser $parser
	 *
	 * @since 2.0
	 */
	public function __construct(MarkdownParser $parser = null)
	{
		$this->markdown = $parser ?: new MarkdownParser;
	}

	/**
	 * Parse the view
	 *
	 * @param string $file path to view file
	 * @param array  $data view data
	 *
	 * @return string parsed view
	 *
	 * @since 2.0
	 */
	public function parse($file, Array $data = null)
	{
		$contents = $file;

		if (file_exists($file))
		{
			$contents = file_get_contents($file);
		}

		return $this->markdown->transformMarkdown($contents);
	}

}
