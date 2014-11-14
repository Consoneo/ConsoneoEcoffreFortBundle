<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Tests;

use Consoneo\Bundle\EcoffreFortBundle\Coffre;
use Mockery as m;
use Symfony\Component\Yaml\Parser;

class CoffreTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Coffre
	 */
	private $coffre;


	protected  function setUp()
	{
		if (! file_exists(__DIR__ . '/parameter.yml'))
		{
			throw new \Exception('for run the test, please copy the file /Tests/parameter.yml.dist to /Tests/parameter.yml with your own configuration');
		}

		$yaml = new Parser();
		list($email, $safeId, $partId, $password) =  $yaml->parse(file_get_contents(__DIR__ . '/parameter.yml'))['coffre'];

		$this->coffre =  new Coffre($email, $safeId, $partId, $password);
		$this->coffre->setDoctrine($this->getMockDoctrine());
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

		$response = $this->coffre->putFile('test.txt', 'test', $file, 'commentaire');

		$response = explode('|', $response);

		$this->assertEquals(0, $response[0]);
		$this->assertEquals(strtoupper(md5_file(realpath($file))), $response[2]);

		@$this->coffre->removeFile($response[1]);
	}

	public function testGetFile()
	{
		$file = __DIR__ . '/test.txt';

		$response = $this->coffre->putFile('test.txt', 'test', $file, 'commentaire');

		$response = explode('|', $response);

		$this->assertEquals('ceci est un document de test !', $this->coffre->getFile($response[1]));

		@$this->coffre->removeFile($response[1]);
	}

	public function testDelFile()
	{
		$file = __DIR__ . '/test.txt';

		$response = $this->coffre->putFile('testRemove.txt', 'test', $file, 'commentaire');
		$response = explode('|', $response);

		$remove = $this->coffre->removeFile($response[1]);

		$this->assertEquals(0, $remove);
	}

	public function testCert()
	{
		$file = __DIR__ . '/test.txt';

		$fileCert = __DIR__ . '/test.pdf';

		$response = $this->coffre->putFile('test.txt', 'test', $file, 'commentaire');

		$response = explode('|', $response);

		file_put_contents($fileCert, $this->coffre->getCert($response[1]));

		@$this->coffre->removeFile($response[1]);
		@unlink($fileCert);
	}

	public function testMoveFile()
	{
		$file = __DIR__ . '/test.txt';
		$response = $this->coffre->putFile('test.txt', 'test/origin', $file);
		$response = explode('|', $response);

		$responseMove = $this->coffre->moveFile($response[1], 'test/target');
		$this->assertEquals(0, $responseMove);

		@$this->coffre->removeFile($response[1]);
	}
}