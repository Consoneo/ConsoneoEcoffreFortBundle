<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class MoveEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.move';

	/**
	 * @var String
	 */
	private $targetDir;


	/**
	 * @param $safeId
	 * @param $iua
	 * @param $codeRetour
	 * @param $targetDir
	 */
	public function __construct($safeId, $iua, $codeRetour, $targetDir)
	{
		$this->targetDir    =   $targetDir;
		parent::__construct(LogQuery::COFFRE, null, $safeId, $iua, $codeRetour);
	}

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_MOVE;
	}

	/**
	 * @return String
	 */
	public function getTargetDir()
	{
		return $this->targetDir;
	}
}
