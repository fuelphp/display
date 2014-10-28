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

class View extends DataContainer
{

	/**
	 * @var  string  $file
	 */
	protected $file;

	/**
	 * @var AbstractParser $parser
	 */
	protected $parser;

	/**
	 * @var ViewManager $manager
	 */
	protected $manager;

	/**
	 * @param ViewManager    $manager
	 * @param AbstractParser $parser
	 * @param string         $file
	 * @param bool           $filter
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
	 * Retrieve all view data from the view and the manager
	 *
	 * @return array View data
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
	 * Render the view.
	 *
	 * @param array $data additional view data
	 *
	 * @return string Rendered view
	 *
	 * @since 2.0
	 */
	public function render(array $data = array())
	{
		if ($data !== null)
		{
			$this->set($data);
		}

		$this->parser->set($this);

		return $this->parser->parse($this->file);
	}

	/**
	 * Render the view
	 *
	 * @return string rendered view
	 *
	 * @since 2.0
	 */
	public function __toString()
	{
		return $this->render();
	}
}
