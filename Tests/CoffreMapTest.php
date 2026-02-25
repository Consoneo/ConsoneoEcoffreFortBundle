<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Tests;

use Consoneo\Bundle\EcoffreFortBundle\Coffre;
use Consoneo\Bundle\EcoffreFortBundle\CoffreMap;
use PHPUnit\Framework\TestCase;

class CoffreMapTest extends TestCase
{
	/**
	 * @var CoffreMap
	 */
	private $coffreMap;

	public function setUp(): void
	{
		$this->coffreMap = new CoffreMap(array('consoneo' => $this->getCoffre(), 'obligeX' => $this->getCoffre()));
	}

	#[\PHPUnit\Framework\Attributes\Test]
	public function shouldGetFilesystemByKey()
	{
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\Coffre', $this->coffreMap->get('consoneo'), 'should get coffre object by key');
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\Coffre', $this->coffreMap->get('obligeX'), 'should get coffre object by key');
	}

	#[\PHPUnit\Framework\Attributes\Test]
	public function shouldNotGetFilesystemWhenKeyWasNotSet()
	{
		$this->expectException(\InvalidArgumentException::class);
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
