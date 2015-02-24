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

use Codeception\TestCase\Test;

/**
 * Tests for ViewManager
 *
 * @package Fuel\Display
 *
 * @coversDefaultClass Fuel\Display\ViewManager
 * @group              Display
 */
class ViewManagerTest extends Test
{
	/**
	 * @var \Mockery\Mock
	 */
	protected $finderMock;

	/**
	 * @var ViewManager
	 */
	protected $viewManager;

	public function _before()
	{
		$this->finderMock = \Mockery::mock('Fuel\FileSystem\Finder');

		$this->viewManager = new ViewManager($this->finderMock, [
			'parsers'     => [],
			'cache'       => true,
			'auto_filter' => true,
			'view_folder' => 'views/',
			'whitelist'   => [],
		]);
	}

	/**
	 * @covers ::__construct
	 * @covers ::configure
	 * @covers ::setViewFolder
	 * @covers ::whitelist
	 */
	public function testConfig()
	{
		$this->viewManager->setViewFolder('other_views');
		$this->viewManager->whitelist('stdClass');

		$this->assertEquals('other_views', $this->viewManager->viewFolder);
	}

	/**
	 * @covers ::registerParser
	 * @covers ::getParser
	 */
	public function testParser()
	{
		$parser = \Mockery::mock('Fuel\Display\Parser\AbstractParser');

		$parser
			->shouldReceive('setViewManager')
			->with($this->viewManager)
			->once();

		$this->assertNull($this->viewManager->getParser('parser'));

		$this->viewManager->registerParser('parser', $parser);

		$this->assertSame($parser, $this->viewManager->getParser('parser'));
	}

	/**
	 * @covers ::registerParsers
	 * @covers ::getParsers
	 */
	public function testParsers()
	{
		$parser = \Mockery::mock('Fuel\Display\Parser\AbstractParser');

		$parser
			->shouldReceive('setViewManager')
			->with($this->viewManager)
			->once();

		$this->viewManager->registerParsers(['parser' => $parser]);

		$this->assertEquals(['parser' => $parser], $this->viewManager->getParsers());
	}

	/**
	 * @covers ::getFinder
	 * @covers ::setFinder
	 */
	public function testFinder()
	{
		$this->assertSame($this->finderMock, $this->viewManager->getFinder());

		$finderMock = \Mockery::mock('Fuel\FileSystem\Finder');
		$this->viewManager->setFinder($finderMock);

		$this->assertSame($finderMock, $this->viewManager->getFinder());
	}

	/**
	 * @covers ::findView
	 */
	public function testFindView()
	{
		$this->finderMock
			->shouldReceive('findFileReversed')
			->with('views/file.php')
			->andReturn('views/file.php')
			->once();

		$this->assertEquals('views/file.php', $this->viewManager->findView('file.php'));
	}

	/**
	 * @covers ::forge
	 */
	public function testForge()
	{
		$this->finderMock
			->shouldReceive('findFileReversed')
			->with('views/file.php')
			->andReturn('views/file.php')
			->once();

		$parser = \Mockery::mock('Fuel\Display\Parser\AbstractParser');

		$parser
			->shouldReceive('setViewManager')
			->with($this->viewManager)
			->once();

		$this->viewManager->registerParser('php', $parser);

		$view = $this->viewManager->forge('file.php', ['foo' => 'bar']);

		$this->assertInstanceOf('Fuel\Display\View', $view);
	}

	/**
	 * @covers            ::forge
	 * @expectedException Fuel\Display\ViewNotFoundException
	 */
	public function testForgeViewNotFound()
	{
		$this->finderMock
			->shouldReceive('findFileReversed')
			->with('views/file.php')
			->andReturn(false)
			->once();

		$this->viewManager->forge('file.php');
	}

	/**
	 * @covers            ::forge
	 * @expectedException DomainException
	 */
	public function testForgeNoParser()
	{
		$this->finderMock
			->shouldReceive('findFileReversed')
			->with('views/file.php')
			->andReturn('views/file.php')
			->once();

		$this->viewManager->forge('file.php');
	}
}
