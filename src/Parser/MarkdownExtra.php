<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display\Parser;

use dflydev\markdown\MarkdownExtraParser;

/**
 * Allows the parsing of view files using MarkdownExtra
 */
class MarkdownExtra extends Markdown
{
	/**
	 * @param MarkdownExtraParser $parser
	 */
	public function __construct(MarkdownExtraParser $parser = null)
	{
		parent::__construct($parser);
	}

}
