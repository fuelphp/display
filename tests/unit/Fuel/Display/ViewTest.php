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
 * Tests for View
 *
 * @package Fuel\Display
 * @coversDefaultClass Fuel\Display\View
 */
class ViewTest extends Test
{

	/**
	 * @var \Mockery\Mock
	 */
	protected $managerMock;

	/**
	 * @var \Mockery\Mock
	 */
	protected $parserMock;

	/**
	 * @var View
	 */
	protected $view;

	public function _before()
	{
		$this->managerMock = \Mockery::mock('Fuel\Display\ViewManager');
		$this->parserMock = \Mockery::mock('Fuel\Display\Parser\AbstractParser');

		$this->view = new View($this->managerMock, $this->parserMock, 'file', null);
	}

	/**
	 * @covers ::getData
	 * @covers ::__construct
	 * @group  Display
	 */
	public function testGetData()
	{
		$this->view->set('baz', 'bat');

		$this->managerMock
			->shouldReceive('getData')
			->once()
			->andReturn(['foo' => 'bar']);

		$this->assertEquals(
			[
				'baz' => 'bat',
				'foo' => 'bar',
			],
			$this->view->getData()
		);
	}

	/**
	 * @covers ::render
	 * @group  Display
	 */
	public function testRender()
	{
		$this->parserMock
			->shouldReceive('parse')
			->with('file', [])
			->andReturn('')
			->once();

		$this->managerMock
			->shouldReceive('getData')
			->once()
			->andReturn([]);

		$this->view->render();
	}

	/**
	 * @covers ::render
	 * @group  Display
	 */
	public function testRenderWithData()
	{
		$data = [
			'foo' => 'bar',
		];

		$this->parserMock
			->shouldReceive('parse')
			->with('file', $data)
			->andReturn('')
			->once();

		$this->managerMock
			->shouldReceive('getData')
			->once()
			->andReturn([]);

		$this->view->render($data);
	}

	/**
	 * @covers ::__toString
	 * @group  Display
	 */
	public function testRenderWithToString()
	{
		$this->parserMock
			->shouldReceive('parse')
			->with('file', [])
			->andReturn('')
			->once();

		$this->managerMock
			->shouldReceive('getData')
			->once()
			->andReturn([]);

		$result = (string) $this->view;
	}

}
