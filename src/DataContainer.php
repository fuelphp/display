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

use Fuel\Common\DataContainer as Container;

/**
 * Contains view data
 *
 * @package Fuel\Display
 *
 * @since 2.0
 */
abstract class DataContainer extends Container
{
	/**
	 * Stores information about data should be filtered or not
	 *
	 * Can have three values:
	 * - true: filter it
	 * - false: don't filter it
	 * - null: use the autoFilter
	 *
	 * @var array
	 */
	protected $filterIndex = [];

	/**
	 * @var boolean
	 */
	protected $autoFilter = false;

	/**
	 * @var array
	 */
	protected $whitelist = [
		'Fuel\Display\View',
		'Fuel\Display\Presenter',
		'Fuel\Display\Whitelisted',
		'Closure',
	];

	/**
	 * Sets the auto filter setting
	 *
	 * @param boolean $filter
	 *
	 * @since 2.0
	 */
	public function autoFilter($filter = true)
	{
		$this->autoFilter = $filter;
	}

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
			if (is_object($value) and $this->isWhitelisted($value))
			{
				continue;
			}

			if ($this->shouldBeFiltered($key))
			{
				if ($value instanceOf Sanitize)
				{
					$data[$key] = $value->sanitizeObject();
				}
				else
				{
					$data[$key] = $this->filter($value);
				}
			}
		}

		return $data;
	}

	/**
	 * Checks if a key should be filtered or not
	 *
	 * Uses filterIndex and autoFilter
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	protected function shouldBeFiltered($key)
	{
		if (isset($this->filterIndex[$key]))
		{
			return $this->filterIndex[$key];
		}

		return $this->autoFilter;
	}

	/**
	 * Checks if an object is whitelisted
	 *
	 * @param object $object
	 *
	 * @return boolean
	 */
	protected function isWhitelisted($object)
	{
		foreach ($this->whitelist as $whitelisted)
		{
			if ($object instanceof $whitelisted)
			{
				return true;
			}
		}

		return false;
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
		if (is_array($value) or (is_object($value) and $value instanceof \ArrayAccess))
		{
			return array_map([$this, 'filter'], $value);
		}

		return htmlentities($value, ENT_QUOTES | ENT_HTML5);
	}

	/**
	 * Sets view data
	 *
	 * @param string|array $key
	 * @param mixed        $value
	 * @param boolean      $filter
	 *
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function set($key, $value = null, $filter = null)
	{
		parent::set($key, $value);

		if (is_array($key))
		{
			if (is_bool($value))
			{
				$filter = $value;
			}

			foreach ($key as $_key => $_value)
			{
				$this->filterIndex[$_key] = $filter;
			}
		}
		else
		{
			$this->filterIndex[$key] = $filter;
		}

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function merge($arg)
	{
		call_user_func_array('parent::merge', func_get_args());

		$arguments = array_map(function ($array) use (&$valid)
		{
			if ($array instanceof DataContainer)
			{
				return $array->filterIndex;
			}

			return [];

		}, func_get_args());

		array_unshift($arguments, $this->filterIndex);
		$this->filterIndex = call_user_func_array('array_merge', $arguments);

		return $this;
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
		$this->setContents([]);
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
	 * @return $this
	 *
	 * @since 2.0
	 */
	public function bind($key, &$value, $filter = null)
	{
		if ($this->readOnly)
		{
			throw new \RuntimeException('Changing values on this Data Container is not allowed.');
		}

		$this->data[$key] =& $value;
		$this->filterIndex[$key] = $filter;
		$this->isModified = true;

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
}
