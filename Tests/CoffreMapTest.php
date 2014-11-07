<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Tests;

use Consoneo\Bundle\EcoffreFortBundle\Coffre;
use Consoneo\Bundle\EcoffreFortBundle\CoffreMap;

class CoffreMapTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var CoffreMap
	 */
	private $coffreMap;

	public function setUp()
	{
		$this->coffreMap = new CoffreMap(array('consoneo' => $this->getCoffre(), 'obligeX' => $this->getCoffre()));
	}

	/**
	 * @test
	 */
	public function shouldGetFilesystemByKey()
	{
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\Coffre', $this->coffreMap->get('consoneo'), 'should get coffre object by key');
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\Coffre', $this->coffreMap->get('obligeX'), 'should get coffre object by key');
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function shouldNotGetFilesystemWhenKeyWasNotSet()
	{
		$this->coffreMap->get('test');
	}

	/**
	 * @return Coffre
	 */
	private function getCoffre()
	{
		return $this->getMockBuilder('Consoneo\Bundle\EcoffreFortBundle\Coffre')
			->disableOriginalConstructor()
			->getMock();
	}
}
