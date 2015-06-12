<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Tests;

use Consoneo\Bundle\EcoffreFortBundle\CoffreMap;
use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Consoneo\Bundle\EcoffreFortBundle\TiersArchivageMap;

class TiersArchivageMapTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var CoffreMap
	 */
	private $coffreMap;

	public function setUp()
	{
		$this->coffreMap = new TiersArchivageMap(array('consoneo' => $this->getTiersArchivage(), 'obligeX' => $this->getTiersArchivage()));
	}

	/**
	 * @test
	 */
	public function shouldGetFilesystemByKey()
	{
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\TiersArchivage', $this->coffreMap->get('consoneo'), 'should get tiers archivage object by key');
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\TiersArchivage', $this->coffreMap->get('obligeX'), 'should get tiers archivage by key');
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
	 * @return TiersArchivage
	 */
	private function getTiersArchivage()
	{
		return $this->getMockBuilder('Consoneo\Bundle\EcoffreFortBundle\TiersArchivage')
			->disableOriginalConstructor()
			->getMock();
	}
}
