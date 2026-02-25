<?php

namespace Consoneo\Bundle\EcoffreFortBundle;

use Consoneo\Bundle\EcoffreFortBundle\EventSubscriber\CoffreSubscriber;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class ECoffreFort
{

	/**
	 * @var String
	 */
	protected $safe_id;

	/**
	 * @var ManagerRegistry
	 */
	protected $doctrine;

	/**
	 * @var EventDispatcher
	 */
	protected $dispatcher;

	/**
	 * @var LoggerInterface
	 */
	protected $logger;

	public function setDoctrine(ManagerRegistry $doctrine)
	{
		$this->doctrine     = $doctrine;
		$this->dispatcher   = new EventDispatcher();
		$this->dispatcher->addSubscriber(new CoffreSubscriber($this->doctrine->getManager()));
	}

	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * @return String
	 */
	public function getSafeId()
	{
		return $this->safe_id;
	}
}
