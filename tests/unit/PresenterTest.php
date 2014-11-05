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
 * Tests for Presenter
 *
 * @package Fuel\Display
 *
 * @coversDefaultClass Fuel\Display\Presenter
 * @group              Display
 */
class PresenterTest extends Test
{
	/**
	 * @var \Mockery\Mock
	 */
	protected $managerMock;

	/**
	 * @var \Mockery\Mock
	 */
	protected $viewMock;

	/**
	 * @var Presenter
	 */
	protected $presenter;

	public function _before()
	{
		$this->managerMock = \Mockery::mock('Fuel\Display\ViewManager');
		$this->viewMock = \Mockery::mock('Fuel\Display\View');

		$this->presenter = new PresenterStub($this->managerMock, 'present', true, $this->viewMock);
	}

	/**
	 * @covers ::getData
	 * @covers ::__construct
	 */
	public function testGetData()
	{
		$this->presenter->set('baz', 'bat');

		$this->managerMock
			->shouldReceive('getData')
			->once()
			->andReturn(['foo' => 'bar']);

		$this->assertEquals(
			[
				'baz' => 'bat',
				'foo' => 'bar',
			],
			$this->presenter->getData()
		);
	}

	/**
	 * @covers ::setView
	 */
	public function testSetView()
	{
		$this->managerMock
			->shouldReceive('forge')
			->with('file')
			->once()
			->andReturn($this->viewMock);

		$this->presenter->setView('file');
	}

	/**
	 * @covers ::render
	 */
	public function testRender()
	{
		$this->viewMock
			->shouldReceive('merge')
			->with($this->presenter)
			->once();

		$this->viewMock
			->shouldReceive('autoFilter')
			->with(true)
			->once();

		$this->viewMock
			->shouldReceive('render')
			->with([])
			->once()
			->andReturn('');

		$this->presenter->render();
	}

	/**
	 * @covers ::__toString
	 */
	public function testRenderWithToString()
	{
		$this->viewMock
			->shouldReceive('merge')
			->with($this->presenter)
			->once();

		$this->viewMock
			->shouldReceive('autoFilter')
			->with(true)
			->once();

		$this->viewMock
			->shouldReceive('render')
			->with([])
			->once()
			->andReturn('');

		$result = (string) $this->presenter;
	}
}
