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
 * Allows Markdown templates to be parsed
 *
 * @package Fuel\Display
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
		$this->markdown = $parser;
	}

	/**
	 * Returns the Markdown Parser
	 *
	 * @return MarkdownParser
	 *
	 * @since 2.0
	 */
	public function getMarkdown()
	{
		if ($this->markdown === null)
		{
			$this->setupMarkdown();
		}

		return $this->markdown;
	}

	/**
	 * Setups the Markdown Parser
	 *
	 * @since 2.0
	 */
	protected function setupMarkdown()
	{
		$this->markdown = new MarkdownParser;
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse($file, array $data = null)
	{
		$contents = $file;

		if (file_exists($file))
		{
			$contents = file_get_contents($file);
		}

		return $this->markdown->transformMarkdown($contents);
	}

}
