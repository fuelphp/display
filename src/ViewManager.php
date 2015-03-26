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

use Fuel\FileSystem\Finder;

/**
 * Responsible for loading and parsing views
 */
class ViewManager extends DataContainer
{
	/**
	 * @var Finder $finder
	 */
	protected $finder;

	/**
	 * Available view parsers
	 *
	 * @var Parser[]
	 */
	protected $parsers = [];

	/**
	 * View folder name prefix
	 *
	 * @var string
	 */
	public $viewFolder = 'views';

	/**
	 * @var string
	 */
	public $cachePath;

	/**
	 * @param Finder $finder
	 * @param array  $config
	 */
	public function __construct(Finder $finder, array $config = [])
	{
		$this->setFinder($finder);
		$this->configure($config);
	}

	/**
	 * Configures the view manager
	 *
	 * @param array $config
	 */
	protected function configure(array $config)
	{
		if (isset($config['parsers']))
		{
			$this->registerParsers($config['parsers']);
		}

		if (isset($config['cache']))
		{
			$this->cachePath = rtrim('cache', '\\/').DIRECTORY_SEPARATOR;
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
	 * Sets the view folder
	 *
	 * @param string $folder
	 */
	public function setViewFolder($folder)
	{
		$this->viewFolder = rtrim($folder, '/ ');
	}

	/**
	 * Adds the given classes to the whitelist.
	 *
	 * @param string[] $classes
	 */
	public function whitelist($classes)
	{
		if ( ! is_array($classes))
		{
			$classes = func_get_args();
		}

		$this->whitelist = array_unique(array_merge($this->whitelist, $classes));
	}

	/**
	 * Registers a new parser for rendering a given file type
	 *
	 * @param string $extension
	 * @param Parser $parser
	 */
	public function registerParser($extension, Parser $parser)
	{
		if ($parser instanceof ViewManagerAware)
		{
			$parser->setViewManager($this);
		}

		$this->parsers[$extension] = $parser;
	}

	/**
	 * Registers multiple parsers at once
	 *
	 * @param array $parsers Key as the file extension and value as the parser instance
	 */
	public function registerParsers(array $parsers)
	{
		foreach ($parsers as $extension => $parser)
		{
			$this->registerParser($extension, $parser);
		}
	}

	/**
	 * Returns a parser by extension
	 *
	 * @return Parser|null
	 */
	public function getParser($extension)
	{
		if (isset($this->parsers[$extension]))
		{
			return $this->parsers[$extension];
		}
	}

	/**
	 * Returns the parsers
	 *
	 * @return Parser[]
	 */
	public function getParsers()
	{
		return $this->parsers;
	}

	/**
	 * Returns the Finder instance
	 *
	 * @return Finder
	 */
	public function getFinder()
	{
		return $this->finder;
	}

	/**
	 * Sets the Finder instance that will be used to load views
	 *
	 * @param Finder $finder
	 */
	public function setFinder(Finder $finder)
	{
		$this->finder = $finder;
	}

	/**
	 * Attempts to get the file name for the given view
	 *
	 * @param $view
	 *
	 * @return array|\Fuel\FileSystem\Directory|\Fuel\FileSystem\File|string
	 */
	public function findView($view)
	{
		$view = $this->viewFolder.DIRECTORY_SEPARATOR.ltrim($view, DIRECTORY_SEPARATOR);

		return $this->finder->findFileReversed($view);
	}

	/**
	 * Attempts to find and load the given view
	 *
	 * @param string    $view
	 * @param array     $data
	 * @param null|bool $filter
	 *
	 * @return View
	 *
	 * @throws Exception\ViewNotFound If the given view cannot be found
	 * @throws \DomainException       If a parser for the view cannot be found
	 */
	public function forge($view, array $data = null, $filter = null)
	{
		if ( ! $file = $this->findView($view))
		{
			throw new Exception\ViewNotFound('Could not locate view: '.$view);
		}

		if ($filter === null)
		{
			$filter = $this->autoFilter;
		}

		$extension = pathinfo($file, PATHINFO_EXTENSION);

		if ( ! isset($this->parsers[$extension]))
		{
			throw new \DomainException('Could not find parser for extension: '.$extension);
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
