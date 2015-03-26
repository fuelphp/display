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
 * Tests for DataContainer
 *
 * @package Fuel\Display
 *
 * @coversDefaultClass Fuel\Display\DataContainer
 * @group              Display
 */
class ContainerTest extends Test
{
	/**
	 * @var Container
	 */
	protected $container;

	public function _before()
	{
		$this->container = new ContainerStub;
	}

	/**
	 * @covers ::autoFilter
	 */
	public function testAutoFilter()
	{
		$property = new \ReflectionProperty(get_class($this->container), 'autoFilter');
		$property->setAccessible(true);
		$this->assertFalse($property->getValue($this->container));

		$this->container->autoFilter();

		$this->assertTrue($property->getValue($this->container));
	}

	public function testData()
	{
		$whitelisted = \Mockery::mock('Fuel\Display\Whitelisted');
		$sanitize = \Mockery::mock('Fuel\Display\Sanitize');
		$reference = null;

		$sanitize
			->shouldReceive('sanitize')
			->once()
			->andReturn('sanitized');

		$this->container->set('whitelisted', $whitelisted);
		$this->container->set('sanitize', $sanitize, true);
		$this->container->bind('reference', $reference);
		$this->container->set('baz', ['bat', 'bat', 'bat'], true);
		$this->container->set('foo', 'bar');
		$this->container->setSafe('bar', 'foo');

		$this->assertEquals(
			[
				'whitelisted' => $whitelisted,
				'sanitize'    => 'sanitized',
				'reference'   => $reference,
				'baz'         => ['bat', 'bat', 'bat'],
				'foo'         => 'bar',
				'bar'         => 'foo',
			],
			$data = $this->container->getData()
		);

		$this->assertSame($reference, $data['reference']);
	}

	public function testSetArray()
	{
		$sanitize = \Mockery::mock('Fuel\Display\Sanitize');

		$sanitize
			->shouldReceive('sanitize')
			->once()
			->andReturn('sanitized');

		$this->container->set(['some' => $sanitize], true);

		$this->assertEquals(['some' => 'sanitized'], $this->container->getData());
	}

	/**
	 * @covers ::merge
	 */
	public function testMerge()
	{
		$container = new ContainerStub;

		$sanitize = \Mockery::mock('Fuel\Display\Sanitize');

		$sanitize
			->shouldReceive('sanitize')
			->once()
			->andReturn('sanitized');

		$container->set([
			'sanitize' => $sanitize,
			'foo'      => 'bar',
		], true);

		$this->container->set('foo', 'not_bar', false);

		$this->container->merge(['foo' => 'still_not_bar'], $container);

		$this->assertEquals(
			[
			'sanitize' => 'sanitized',
			'foo'      => 'bar',
			],
			$this->container->getData()
		);
	}

	/**
	 * @covers            ::bind
	 * @expectedException RuntimeException
	 */
	public function testBindReadOnly()
	{
		$this->container->setReadOnly(true);

		$this->container->bind('something', $value);
	}

	/**
	 * @covers ::clearData
	 */
	public function testClearData()
	{
		$this->container->set('some', 'data');

		$this->container->clearData();

		$this->assertEquals([], $this->container->getData());
	}

	/**
	 * @covers ::replaceData
	 */
	public function testReplaceData()
	{
		$this->container->set('some', 'data');

		$this->container->replaceData(['some_other' => 'data']);

		$this->assertEquals(['some_other' => 'data'], $this->container->getData());
	}
}
