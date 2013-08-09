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

use Fuel\FileSystem\Finder;
use Fuel\Display\Parser\AbstractParser;

class ViewManager extends DataContainer
{
	/**
	 * @var  \Fuel\FileSystem\Finder  $finder
	 */
	protected $finder;

	/**
	 * @var  \Fuel\Display\Parser\AbstractParser[]  parsers
	 */
	protected $parsers = array();

	/**
	 * @var  string  view folder name prefix
	 */
	public $viewFolder = 'views';

	/**
	 * @var  string  $cachePath  cache path
	 */
	public $cachePath;

	/**
	 * Constructor
	 *
	 * @param   \Fuel\FileSystem\Finder  $finder
	 * @param   array                       $config
	 */
	public function __construct(Finder $finder, array $config = array())
	{
		$this->setFinder($finder);
		$this->configure($config);
	}

	/**
	 * Configure the view manager
	 *
	 * @param  array  $config
	 */
	protected function configure(array $config)
	{
		if (isset($config['parsers']))
		{
			$this->registerParsers($config['parsers']);
		}

		if (isset($config['cache']))
		{
			$this->cachePath = rtrim('cache', '/').'/';
		}

		if (isset($config['auto_filter']))
		{
			$this->autoFilter = (bool) $config['auto_filter'];
		}

		if (isset($config['view_folder']))
		{
			$this->setViewFolder($config['view_folder']);
		}

		if (isset($config['whitelist']))
		{
			$this->whitelist($config['whitelist']);
		}
	}

	/**
	 * Set the view folder
	 *
	 * @param   string  $folder  folder path
	 * @return  $this
	 */
	public function setViewFolder($folder)
	{
		$this->viewFolder = rtrim($folder, '/ ');

		return $this;
	}

	public function whitelist($classes)
	{
		if ( ! is_array($classes))
		{
			$classes = func_get_args();
		}

		$this->whitelist = array_merge($this->whitelist, $classes);

		return $this;
	}

	public function registerParser($extension, AbstractParser $parser)
	{
		$parser->setManager($this);
		$this->parsers[$extension] = $parser;

		return $this;
	}

	public function registerParsers(array $parsers)
	{
		foreach ($parsers as $extension => $parser)
		{
			$this->registerParser($extension, $parser);
		}

		return $this;
	}

	public function getFinder()
	{
		return $this->finder;
	}

	public function setFinder(Finder $finder)
	{
		$this->finder = $finder;

		return $this;
	}

	public function findView($view)
	{
		$view = $this->viewFolder.'/'.ltrim($view, '/');

		return $this->finder->findFileReversed($view);
	}

	public function forge($view, array $data = null, $filter = null)
	{
		if ( ! $file = $this->findView($view))
		{
			throw new ViewNotFoundException('Could not locate view: '.$view);
		}

		if ($filter === null)
		{
			$filter = $this->autoFilter;
		}

		$extension = pathinfo($file, PATHINFO_EXTENSION);

		if ( ! isset($this->parsers[$extension]))
		{
			throw new Exception('Could not find parser for extension: '.$extension);
		}

		$parser = $this->parsers[$extension];
		$view = new View($this, $parser, $file, $filter);

		if ($data)
		{
			$view->set($data);
		}

		return $view;
	}
}
