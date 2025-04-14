<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class QueryEvent implements EventSubscriberInterface
{
	/**
	 * @var String
	 */
	protected $serviceType;

	/**
	 * @var String
	 */
	protected $safeRoom;

	/**
	 * @var String
	 */
	protected $safeId;

	/**
	 * @var String
	 */
	protected $codeRetour;

	/**
	 * @var String
	 */
	protected $iua;


	/**
	 * @param $serviceType
	 * @param null $safeRoom
	 * @param $safeId
	 * @param $iua
	 * @param $codeRetour
	 */
	public function __construct($serviceType, $safeRoom = null, $safeId, $iua = null, $codeRetour)
	{
		$this->safeId       =   $safeId;
		$this->iua          =   $iua;
		$this->safeRoom     =   $safeRoom;
		$this->serviceType  =   $serviceType;
		$this->setCodeRetour($codeRetour);
	}

	/**
	 * @return String
	 */
	public function getSafeId()
	{
		return $this->safeId;
	}

	/**
	 * @return String
	 */
	public function getCodeRetour()
	{
		return $this->codeRetour;
	}

	/**
	 * @return String
	 */
	public function getIua()
	{
		return $this->iua;
	}

	/**
	 * @param $codeRetour
	 * @return $this
	 */
	public function setCodeRetour($codeRetour)
	{
		if (strlen($codeRetour) > 3) {
			$codeRetour = 0;
		}
		$this->codeRetour = $codeRetour;
		return $this;
	}

	/**
	 * @return String
	 */
	public function getServiceType()
	{
		return $this->serviceType;
	}

	/**
	 * @return String
	 */
	public function getSafeRoom()
	{
		return $this->safeRoom;
	}

}
