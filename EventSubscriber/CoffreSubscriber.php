<?php

namespace Consoneo\Bundle\ECoffreFortBundle\EventSubscriber;

use Consoneo\Bundle\EcoffreFortBundle\Entity\Annuaire;
use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;
use Consoneo\Bundle\EcoffreFortBundle\Event\DelEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\GetEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\PutEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\QueryEventInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CoffreSubscriber implements EventSubscriberInterface {

	/**
	 * @var Registry
	 */
	private $doctrine;

	public function __Construct(Registry $doctrine)
	{
		$this->doctrine =   $doctrine;
	}

	public static function getSubscribedEvents()
	{
		return array(
			PutEvent::NAME  => [
				['logQuery'],
				['putAnnuaire'],
			],
			GetEvent::NAME  => 'logQuery',
			DelEvent::NAME  => [
				['logQuery'],
				['delAnnuaire']
			],
		);
	}

	/**
	 * @param QueryEventInterface $queryEvent
	 */
	public function logQuery(QueryEventInterface $queryEvent)
	{
		$logQuery = (new LogQuery())
			->setIua($queryEvent->getIua())
			->setSafeId($queryEvent->getSafeId())
			->setQueryType($queryEvent->getQueryType())
			->setReturnCode($queryEvent->getCodeRetour())
		;

		$this->getManager()->persist($logQuery);
		$this->getManager()->flush($logQuery);
	}

	/**
	 * @param PutEvent $putEvent
	 */
	public function putAnnuaire(PutEvent $putEvent)
	{
		$putAnnuaire = (new Annuaire())
			->setSafeId($putEvent->getSafeId())
			->setIua($putEvent->getIua())
			->setTargetDir($putEvent->getTargetDir())
			->setDocName($putEvent->getDocName())
			->setMd5DocName($putEvent->getMd5DocName())
		;

		$this->getManager()->persist($putAnnuaire);
		$this->getManager()->flush($putAnnuaire);
	}

	/**
	 * @param DelEvent $delEvent
	 */
	public function delAnnuaire(DelEvent $delEvent)
	{
		$archive = $this->getManager()->getRepository('ConsoneoEcoffreFortBundle:Annuaire')
			->findOneBy([
				'safeId'    =>  $delEvent->getSafeId(),
				'iua'       =>  $delEvent->getIua(),
			]);

		if ($archive) {
			$this->getManager()->remove($archive);
			$this->getManager()->flush($archive);
		}
	}

	/**
	 * @return EntityManager
	 */
	private function getManager()
	{
		return $this->doctrine->getManager();
	}
}