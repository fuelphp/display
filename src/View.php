<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display;

use Fuel\Display\Parser\AbstractParser;

/**
 * Responsible for rendering a view
 */
class View extends DataContainer
{
	/**
	 * @var string
	 */
	protected $file;

	/**
	 * @var AbstractParser
	 */
	protected $parser;

	/**
	 * @var ViewManager
	 */
	protected $viewManager;

	/**
	 * @param ViewManager    $viewManager
	 * @param AbstractParser $parser
	 * @param string         $file
	 * @param boolean        $autoFilter
	 */
	public function __construct(ViewManager $viewManager, AbstractParser $parser, $file, $autoFilter)
	{
		$this->file = $file;
		$this->parser = $parser;
		$this->viewManager = $viewManager;
		$this->autoFilter = $autoFilter;
	}

	/**
	 * Retrieves all view data from the view and the viewManager
	 *
	 * @return array
	 */
	public function getData()
	{
		$data = parent::getData();
		$global = $this->viewManager->getData();

		return array_merge($global, $data);
	}

	/**
	 * Renders the view
	 *
	 * @param array $data additional view data
	 *
	 * @return string
	 */
	public function render(array $data = [])
	{
		if ( ! empty($data))
		{
			$this->set($data);
		}

		return $this->parser->parse($this->file, $this->getData());
	}

	/**
	 * Renders the view
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}
