<?php
/**
 * @package    Fuel\Display
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
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
	 * @var \Fuel\Display\Parser\AbstractParser  $parser
	 */
	protected $parser;

	/**
	 * @var \Fuel\Display\ViewManager  $manager
	 */
	protected $manager;

	/**
	 * @var boolean  $filter
	 */
	protected $autoFilter = false;

	/**
	 * Constructor
	 *
	 * @param  \Fuel\Display\ViewManager  $manager
	 * @param  \Fuel\Display\Parser\AbstractParser  $parser
	 * @param  string  $file
	 * @param  boolean  $filter
	 */
	public function __construct(ViewManager $manager, AbstractParser $parser, $file, $filter)
	{
		$this->file = $file;
		$this->parser = $parser;
		$this->manager = $manager;
		$this->autoFilter = $filter;
	}

	/**
	 * Trieve all viewdata from the view and the manager
	 *
	 * @return  array  view data
	 */
	public function getData()
	{
		$data = parent::getData();
		$global = $this->manager->getData();

		return array_merge($global, $data);
	}

	/**
	 * Render the view
	 *
	 * @param   array  additional viewdata
	 * @return  string  rendered view
	 */
	public function render(array $data = null)
	{
		if ($data) {
			$this->set($data);
		}

		return $this->parser->parse($this->file, $this->getData());
	}

	/**
	 * Render the view
	 *
	 * @return  string  rendered view
	 */
	public function __toString()
	{
		return $this->render();
	}
}
