<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Tests;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Consoneo\Bundle\EcoffreFortBundle\TiersArchivageMap;
use PHPUnit\Framework\TestCase;

class TiersArchivageMapTest extends TestCase
{
	/**
	 * @var TiersArchivageMap
	 */
	private $tiersArchivageMap;

	public function setUp(): void
	{
		$this->tiersArchivageMap = new TiersArchivageMap(array('consoneo' => $this->getTiersArchivage(), 'obligeX' => $this->getTiersArchivage()));
	}

	#[\PHPUnit\Framework\Attributes\Test]
	public function shouldGetFilesystemByKey()
	{
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\TiersArchivage', $this->tiersArchivageMap->get('consoneo'), 'should get tiers archivage object by key');
		$this->assertInstanceOf('Consoneo\Bundle\EcoffreFortBundle\TiersArchivage', $this->tiersArchivageMap->get('obligeX'), 'should get tiers archivage by key');
	}

	#[\PHPUnit\Framework\Attributes\Test]
	public function shouldNotGetFilesystemWhenKeyWasNotSet()
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->tiersArchivageMap->get('test');
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
