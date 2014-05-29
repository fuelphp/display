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

use dflydev\markdown\MarkdownExtraParser;

/**
 * Allows the parsing of view files using MarkdownExtra
 *
 * @package Fuel\Display\Parser
 *
 * @since 2.0
 */
class MarkdownExtra extends Markdown
{

	/**
	 * @param MarkdownExtraParser $parser
	 *
	 * @since 2.0
	 */
	public function __construct(MarkdownExtraParser $parser = null)
	{
		parent::__construct($parser);
	}

}
