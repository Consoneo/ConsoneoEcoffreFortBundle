<?php

namespace Consoneo\Bundle\EcoffreFortBundle\EventSubscriber;

use Consoneo\Bundle\EcoffreFortBundle\Entity\Annuaire;
use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;
use Consoneo\Bundle\EcoffreFortBundle\Event\CertEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\DelEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\GetEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\MoveEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\PutEvent;
use Consoneo\Bundle\EcoffreFortBundle\Event\QueryEventInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CoffreSubscriber implements EventSubscriberInterface {

	/**
	 * @var EntityManager
	 */
	private $em;

	public function __construct(ObjectManager $em)
	{
		$this->em =   $em;
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
			CertEvent::NAME =>  'logQuery',
			MoveEvent::NAME =>  [
				['logQuery'],
				['updateAnnuaire'],
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

		$this->em->persist($logQuery);
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

		$this->em->persist($putAnnuaire);
	}

	/**
	 * @param MoveEvent $moveEvent
	 */
	public function updateAnnuaire(MoveEvent $moveEvent)
	{
		$annuaire = $this->em->getRepository('ConsoneoEcoffreFortBundle:Annuaire')
			->findOneBy([
				'safeId'    =>  $moveEvent->getSafeId(),
				'iua'       =>  $moveEvent->getIua(),
			]);

		if ($annuaire) {
			/** @var $annuaire Annuaire */
			$annuaire->setTargetDir($moveEvent->getTargetDir());
			$this->em->persist($annuaire);
		}
	}

	/**
	 * @param DelEvent $delEvent
	 */
	public function delAnnuaire(DelEvent $delEvent)
	{
		$annuaire = $this->em->getRepository('ConsoneoEcoffreFortBundle:Annuaire')
			->findOneBy([
				'safeId'    =>  $delEvent->getSafeId(),
				'iua'       =>  $delEvent->getIua(),
			]);

		if ($annuaire) {
			$this->em->remove($annuaire);
		}
	}
}