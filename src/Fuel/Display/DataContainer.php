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

use Closure;
use OutOfBoundsException;
use ArrayAccess;

abstract class DataContainer
{
	/**
	 * @var  array  $data  view data
	 */
	protected $data = array();

	/**
	 * @var  array  @filterIndex  filter index
	 */
	protected $filterIndex = array();

	/**
	 * @var  boolean  $autoFilter  auth filter
	 */
	protected $autoFilter = false;

	/**
	 * @var  array  @whileList  whitelisted classes
	 */
	protected $whitelist = array(
		'Fuel\Display\View',
		'Fuel\Display\Whitelisted',
		'Closure',
	);

	/**
	 * Retrieved all the viewdata
	 *
	 * @return  array  view data
	 */
	public function getData()
	{
		$data = $this->data;

		foreach ($data as $key => $value)
		{
			if (is_object($value) and in_array(get_class($value), $this->whitelist))
			{
				$data[$key] = $value;

				continue;
			}

			if ($this->filterIndex[$key])
			{
				if ($value instanceOf Sanitize)
				{
					$data[$key] = $value->sanitizeObject();
				}
				else
				{
					$data[$key] = $this->filter($value);
				}

				continue;
			}

			$data[$key] = $value;
		}

		return $data;
	}

	public function filter($value)
	{
		if (is_array($value) or (is_object($value) and $value instanceof ArrayAccess))
		{
			return array_map([$this, 'filter'], $value);
		}

		return htmlentities($value, ENT_QUOTES | ENT_HTML5);
	}

	/**
	 * Remove all the view data
	 *
	 * @return  $this
	 */
	public function clearData()
	{
		$this->data = array();
		$this->filterIndex = array();

		return $this;
	}

	/**
	 * Overwrite all the viewdata
	 *
	 * @param   array    $data    view data
	 * @param   boolean  $filter  filter boolean
	 * @return  $this
	 */
	public function replaceData(array $data, $filter = null)
	{
		$this->clearData();

		return $this->set($data, $filter);
	}

	/**
	 * Set the auto filter setting
	 *
	 * @param   boolean  $filter  wether to filter the view data
	 * @return  $this;
	 */
	public function autoFilter($filter = true)
	{
		$this->autoFilter = $filter;

		return $this;
	}

	/**
	 * Set view data
	 *
	 * @param   string|array  key or view data array
	 * @param   mixed         $value   view data value
	 * @param   boolean       $filter  wether to filter the view data
	 */
	public function set($key, $value = null, $filter = null)
	{
		if ($key instanceOf DataContainer)
		{
			$this->data = $key->data;
			$this->filterIndex = $key->filterIndex;
		}

		elseif ( ! is_array($key))
		{
			$this->data[$key] = $value;
			$this->filterIndex[$key] = $filter === null ? $this->autoFilter : $filter;
		}

		else
		{
			if (is_bool($value))
			{
				$filter = $value;
			}

			foreach ($key as $_key => $_value)
			{
				$this->data[$_key] = $_value;
				$this->filterIndex[$_key] = $filter === null ? $this->autoFilter : $filter;
			}
		}

		return $this;
	}

	/**
	 * Assigns a value by reference. The benefit of binding is that values can
	 * be altered without re-setting them. It is also possible to bind variables
	 * before they have values. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *     // This reference can be accessed as $ref within the object
	 *     $obj->bind('ref', $bar);
	 *
	 * @param   string   variable name
	 * @param   mixed    referenced variable
	 * @param   bool     Whether to filter the var on output
	 * @return  $this
	 */
	public function bind($key, &$value, $filter = null)
	{
		$this->filterIndex[$key] = $filter === null ? $this->autoFilter : $filter;
		$this->data[$key] =& $value;

		return $this;
	}

	/**
	 * Set safe view data, will not be filtered
	 *
	 * @param   string|array  $key    key or view data array
	 * @param   mixed         $value  view data value
	 * @return  $this
	 */
	public function setSafe($key, $value = null)
	{
		return $this->set($key, $value, false);
	}

	/**
	 * Get data from the container
	 *
	 * @param   string  $key      view data key
	 * @param   mixed   $default  default value
	 * @return  mixed   view data value
	 */
	public function get($key, $default = null)
	{
		if ( ! isset($this->data[$key]))
		{
			return $default instanceof Closure ? $default() : $default;
		}

		return $this->data[$key];
	}

	/**
	 * Magic setter
	 *
	 * @param   string  $key      view data key
	 * @param   mixed   $default  default value
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Magic setter
	 *
	 * @param   string  $key      view data key
	 * @param   mixed   $default  default value
	 * @return  mixed   view data value
	 * @throws  OutOfBoundsException  when the property is undefined
	 */
	public function __get($key)
	{
		$default = function() use ($key)
		{
			throw new OutOfBoundsException('Access to undefined property: '.$key);
		};

		return $this->get($key, $default);
	}
}
