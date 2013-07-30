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

class Presenter extends DataContainer
{
	/**
	 * @var \Fuel\Display\View  $view
	 */
	protected $view;

	/**
	 * @var \Fuel\Display\ViewManager  $manager
	 */
	protected $manager;

	/**
	 * @var \Fuel\Foundation\Request  $request
	 */
	protected $request;

	/**
	 * @var boolean  $autoFilter
	 */
	protected $autoFilter = false;

	/**
	 * @var  string  $method method to execute when rendering
	 */
	protected $method;

	/**
	 * Method to do general Presenter setup
	 *
	 * @since  1.0.0
	 */
	public function before() {}

	/**
	 * Method to do general Presenter finishing up
	 *
	 * @since  1.0.0
	 */
	public function after() {}

	/**
	 * Constructor
	 *
	 * @param  string  $method  Method to call before rendering the Presenter view
	 * @param  boolean  $filter  Whether or not to auto filter the view variables
	 * @param  string  $view
	 */
	public function __construct(ViewManager $manager, $method, $autoFilter, $view)
	{
		$this->manager = $manager;
		$this->method = $method === null ? 'view' : $method;
		$this->autoFilter = $autoFilter;
		$this->view = $view;

		$this->request = \Request::getInstance();
	}

	/**
	 * Retrieve all presenter data from the presenter and the global manager
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
	 * Set a new View (object)
	 *
	 * @param  string|View  new view to be used by this presenter
	 *
	 * @return  Presenter
	 */
	public function setView($view)
	{
		$this->view = $view;

		return $this;
	}

	/**
	 * Render the view
	 *
	 * @param   array  additional view data
	 * @return  string  rendered view
	 */
	public function render(Array $data = null)
	{
		// construct the view if needed
		if ( ! $this->view instanceOf \Fuel\Display\View)
		{
			$this->view = \View::forge($this->view);
		}

		// run the methods
		$this->before();
		if (method_exists($this, $this->method))
		{
			$this->{$this->method}();
		}
		$this->after();

		// transfer the presenter data to the view
		$this->view->set($this);

		// render the view
		return $this->view->render($data);
	}

	/**
	 * Render the presenter view
	 *
	 * @return  string  rendered view
	 */
	public function __toString()
	{
		return $this->render();
	}
}
