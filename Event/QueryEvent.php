<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class QueryEvent extends Event
{
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


	public function __construct($safeId, $iua, $codeRetour)
	{
		$this->iua          =   $iua;
		$this->codeRetour   =   $codeRetour;
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
}
