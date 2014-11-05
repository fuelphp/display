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

/**
 * Allows view logic to be encapsulated
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
class Presenter extends DataContainer
{
	/**
	 * @var View
	 */
	protected $view;

	/**
	 * @var ViewManager
	 */
	protected $manager;

	/**
	 * @var boolean
	 */
	protected $autoFilter = false;

	/**
	 * @var string method to execute when rendering
	 */
	protected $method;

	/**
	 * Method to do general Presenter setup
	 *
	 * @since 2.0
	 */
	public function before() {}

	/**
	 * Method to do general Presenter finishing up
	 *
	 * @since 2.0
	 */
	public function after() {}

	/**
	 * @param ViewManager $manager
	 * @param string      $method Method to call before rendering the Presenter view
	 * @param boolean     $filter Whether or not to auto filter the view variables
	 * @param string|View $view
	 *
	 * @since 2.0
	 */
	public function __construct(ViewManager $manager, $method, $autoFilter, $view)
	{
		$this->manager = $manager;
		$this->method = $method === null ? 'view' : $method;
		$this->autoFilter = $autoFilter;

		if ($view !== null)
		{
			$this->setView($view);
		}
	}

	/**
	 * Retrieves all presenter data from the presenter and the global manager
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
	 * Sets a new View (object)
	 *
	 * @param string|View $view
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setView($view)
	{
		$this->view = $view;

		// construct the view if needed
		if ( ! $this->view instanceof View)
		{
			$this->view = $this->manager->forge($this->view);
		}

		return $this;
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
		// run the methods
		$this->before();

		if (method_exists($this, $this->method))
		{
			$this->{$this->method}();
		}

		$this->after();

		// transfer the presenter data to the view
		$this->view->merge($this);

		// set autofilter on view
		$this->view->autoFilter($this->autoFilter);

		// render the view
		return $this->view->render($data);
	}

	/**
	 * Renders the presenter view
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
