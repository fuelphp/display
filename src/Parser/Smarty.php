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

use Smarty as SmartyParser;

/**
 * Allows Smarty templates to be parsed
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class Smarty extends AbstractParser
{
	/**
	 * @var SmartyParser
	 */
	protected $smarty;

	/**
	 * @param SmartyParser $smarty
	 *
	 * @since 2.0
	 */
	public function __construct(SmartyParser $smarty = null)
	{
		$this->smarty = $smarty;
	}

	/**
	 * Returns the Smarty
	 *
	 * @return SmartyParser
	 */
	public function getSmarty()
	{
		if ($this->smarty === null)
		{
			$this->setupSmarty();
		}

		return $this->smarty;
	}

	/**
	 * Sets up Smarty
	 *
	 * @return SmartyParser
	 */
	protected function setupSmarty()
	{
		$this->smarty = new SmartyParser;

		if ($this->manager->cachePath)
		{
			$this->smarty->setCacheDir($this->manager->cachePath.'smarty/');
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse($file, Array $data = null)
	{
		$smarty = $this->getSmarty();

		$template = $smarty->createTemplate($file);
		$template->assign($data ?: $this->getData());

		return $template->fetch();
	}
}
