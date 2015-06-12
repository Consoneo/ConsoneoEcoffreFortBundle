<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Tests;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Mockery as m;
use Symfony\Component\Yaml\Parser;

class TiersArchivageTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var TiersArchivage
	 */
	private $tierArchivage;


	protected  function setUp()
	{
		if (! file_exists(__DIR__ . '/parameter.yml'))
		{
			throw new \Exception('for run the test, please copy the file /Tests/parameter.yml.dist to /Tests/parameter.yml with your own configuration');
		}

		$yaml = new Parser();
		list($safeRoom, $safeId, $userLogin, $userPassword) =  $yaml->parse(file_get_contents(__DIR__ . '/parameter.yml'))['tiers-archivage'];

		$this->tierArchivage =  new TiersArchivage($safeRoom, $safeId, $userLogin, $userPassword);
		$this->tierArchivage->setDoctrine($this->getMockDoctrine());
		$this->tierArchivage->setLogger($this->getMockLogger());
	}



	/**
	 * @return m\MockInterface
	 */
	private function getMockLogger()
	{
		$logger = m::mock('Symfony\Bridge\Monolog\Logger');

		/*$logger
			->shouldReceive('getManager')->times(10)
			->andReturn($this->getMockManager());*/

		return $logger;
	}

	/**
	 * @return m\MockInterface
	 */
	private function getMockDoctrine()
	{
		$doctrine = m::mock('Doctrine\Bundle\DoctrineBundle\Registry');

		$doctrine
			->shouldReceive('getManager')->times(10)
			->andReturn($this->getMockManager());

		return $doctrine;
	}

	private function getMockManager()
	{
		$manager = m::mock('Doctrine\ORM\EntityManager');

		$manager
			->shouldReceive('getRepository')->andReturn($this->getMockRepository())
			->shouldReceive('persist')->times(10)->andReturn(true)
			->shouldReceive('flush')->times(10)->andReturn(true)
		;

		return $manager;
	}

	private function getMockRepository()
	{
		$repo =  m::mock('Doctrine\ORM\EntityRepository');

		$repo
			->shouldReceive('findOneBy')->andReturnNull();
		return $repo;
	}

	public function testPutFile()
	{
		$file = __DIR__ . '/test.txt';

		$response = $this->tierArchivage->putFile('test.txt', $file);

		$response = explode('|', $response);

		$this->assertEquals(0, $response[0]);
		$this->assertEquals(strtoupper(md5_file(realpath($file))), $response[2]);

		@$this->tierArchivage->removeFile($response[1]);
	}

	public function testGetFile()
	{
		$file = __DIR__ . '/test.txt';

		$response = $this->tierArchivage->putFile('test.txt', $file);

		$response = explode('|', $response);

		$this->assertEquals('ceci est un document de test !', $this->tierArchivage->getFile($response[1]));

		@$this->tierArchivage->removeFile($response[1]);
	}

	public function testDelFile()
	{
		$file = __DIR__ . '/test.txt';

		$response = $this->tierArchivage->putFile('testRemove.txt', $file);
		$response = explode('|', $response);

		$remove = $this->tierArchivage->removeFile($response[1]);

		$this->assertEquals(0, $remove);
	}
}