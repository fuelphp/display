<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Display;

use Fuel\Display\Parser\AbstractParser;

/**
 * Responsible for rendering a view
 *
 * @package Fuel\Display
 *
 * @since 2.0
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
	protected $manager;

	/**
	 * @param ViewManager    $manager
	 * @param AbstractParser $parser
	 * @param string         $file
	 * @param boolean        $filter
	 *
	 * @since 2.0
	 */
	public function __construct(ViewManager $manager, AbstractParser $parser, $file, $filter)
	{
		$this->file = $file;
		$this->parser = $parser;
		$this->manager = $manager;
		$this->autoFilter = $filter;
	}

	/**
	 * Retrieves all view data from the view and the manager
	 *
	 * @return array
	 *
	 * @since 2.0
	 */
	public function getData()
	{
		$data = parent::getData();
		$global = $this->manager->getData();

		return array_merge($global, $data);
	}

	/**
	 * Renders the view
	 *
	 * @param array $data additional view data
	 *
	 * @return string
	 *
	 * @since 2.0
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
	 *
	 * @since 2.0
	 */
	public function __toString()
	{
		return $this->render();
	}
}
