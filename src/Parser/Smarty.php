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

class Smarty extends AbstractParser
{
	/**
	 * @var  \Smarty  $smarty
	 */
	protected $smarty;

	/**
	 * Constructor
	 *
	 * @param  \Smarty  $smarty
	 */
	public function __construct(SmartyParser $smarty = null)
	{
		$this->smarty = $smarty;
	}

	/**
	 * Retrieve the Smarty parser
	 *
	 * @return  \Smarty
	 */
	public function getSmarty()
	{
		if ( ! $this->smarty)
		{
			$this->smarty = $this->setupSmarty();
		}

		return $this->smarty;
	}

	/**
	 * Smarty boostrapping
	 *
	 * @return  \Smarty
	 */
	public function setupSmarty()
	{
		$smarty = new SmartyParser();

		if ($this->manager->cachePath)
		{
			$smarty->setCacheDir($this->manager->cachePath.'smarty/');
		}

		return $smarty;
	}

	/**
	 * Parse the view
	 *
	 * @param   string  $file  path to view file
	 * @param   array   $data  view data
	 * @return  string  parsed view
	 */
	public function parse($file, Array $data = null)
	{
		$smarty = $this->getSmarty();
		$template = $smarty->createTemplate($file);
		$template->assign($data ?: $this->getData());

		return $template->fetch();
	}
}
