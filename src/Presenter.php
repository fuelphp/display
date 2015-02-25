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

/**
 * Allows view logic to be encapsulated
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
	protected $viewManager;

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
	 */
	public function before() {}

	/**
	 * Method to do general Presenter finishing up
	 */
	public function after() {}

	/**
	 * @param ViewManager $viewManager
	 * @param string      $method Method to call before rendering the Presenter view
	 * @param boolean     $filter Whether or not to auto filter the view variables
	 * @param string|View $view
	 */
	public function __construct(ViewManager $viewManager, $method, $autoFilter, $view)
	{
		$this->viewManager = $viewManager;
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
	 */
	public function getData()
	{
		$data = parent::getData();
		$global = $this->viewManager->getData();

		return array_merge($global, $data);
	}

	/**
	 * Sets a new View (object)
	 *
	 * @param string|View $view
	 */
	public function setView($view)
	{
		$this->view = $view;

		// construct the view if needed
		if ( ! $this->view instanceof View)
		{
			$this->view = $this->viewManager->forge($this->view);
		}
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
	 */
	public function __toString()
	{
		return $this->render();
	}
}
