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

use Closure;
use OutOfBoundsException;
use ArrayAccess;

/**
 * Contains view data
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
abstract class DataContainer
{
	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * @var array
	 */
	protected $filterIndex = [];

	/**
	 * @var boolean
	 */
	protected $autoFilter = false;

	/**
	 * Whitelisted classes
	 *
	 * @var array
	 */
	protected $whitelist = [
		'Fuel\Display\View',
		'Fuel\Display\Presenter',
		'Fuel\Display\Whitelisted',
		'Closure',
	];

	/**
	 * Retrieves all the view data
	 *
	 * @return array
	 *
	 * @since 2.0
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

	/**
	 * Filters the output
	 *
	 * @param mixed $value
	 *
	 * @return string
	 *
	 * @since 2.0
	 */
	public function filter($value)
	{
		if (is_array($value) or (is_object($value) and $value instanceof ArrayAccess))
		{
			return array_map([$this, 'filter'], $value);
		}

		return htmlentities($value, ENT_QUOTES | ENT_HTML5);
	}

	/**
	 * Removes all the view data
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function clearData()
	{
		$this->data = [];
		$this->filterIndex = [];

		return $this;
	}

	/**
	 * Overwrites all the view data
	 *
	 * @param array   $data
	 * @param boolean $filter
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function replaceData(array $data, $filter = null)
	{
		$this->clearData();

		return $this->set($data, $filter);
	}

	/**
	 * Sets the auto filter setting
	 *
	 * @param boolean $filter
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function autoFilter($filter = true)
	{
		$this->autoFilter = $filter;

		return $this;
	}

	/**
	 * isset magic method
	 */
	public function __isset($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 * unset magic method
	 */
	public function __unset($key)
	{
		unset($this->data[$key]);
	}

	/**
	 * Sets view data
	 *
	 * @param string|array  $key
	 * @param mixed         $value
	 * @param boolean       $filter
	 *
	 * @return $this
	 *
	 * @since 2.0
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
	 * @param string  $key    Variable name
	 * @param mixed   $value  Referenced variable
	 * @param boolean $filter Whether to filter the var on output
	 *
	 * @return  $this
	 *
	 * @since 2.0
	 */
	public function bind($key, &$value, $filter = null)
	{
		$this->filterIndex[$key] = $filter === null ? $this->autoFilter : $filter;
		$this->data[$key] =& $value;

		return $this;
	}

	/**
	 * Sets safe view data, will not be filtered
	 *
	 * @param string|array $key
	 * @param mixed        $value
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function setSafe($key, $value = null)
	{
		return $this->set($key, $value, false);
	}

	/**
	 * Returns data from the container
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 *
	 * @since 2.0
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
	 * @param string $key
	 * @param mixed  $default
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Magic getter
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 *
	 * @throws OutOfBoundsException  If the property is undefined
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
