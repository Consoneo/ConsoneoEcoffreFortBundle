<?php

namespace Consoneo\Bundle\EcoffreFortBundle;

use Consoneo\Bundle\EcoffreFortBundle\EventSubscriber\CoffreSubscriber;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class ECoffreFort
{

	/**
	 * @var String
	 */
	protected $safe_id;

	/**
	 * @var Registry
	 */
	protected $doctrine;

	/**
	 * @var EventDispatcher
	 */
	protected $dispatcher;

	/**
	 * @var Logger
	 */
	protected $logger;

	public function setDoctrine(Registry $doctrine)
	{
		$this->doctrine     = $doctrine;
		$this->dispatcher   = new EventDispatcher();
		$this->dispatcher->addSubscriber(new CoffreSubscriber($this->doctrine->getManager()));
	}

	public function setLogger(Logger $logger)
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
