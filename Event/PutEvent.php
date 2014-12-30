<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class PutEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.put';

	/**
	 * @var String
	 */
	private $docName;

	/**
	 * @var String
	 */
	private $targetDir;

	/**
	 * @var String
	 */
	private $md5DocName;

	public function __construct($docName, $safeId, $targetDir, $retour)
	{
		$this->docName      =   $docName;
		$this->targetDir    =   $targetDir;
		$this->safeId       =   $safeId;
		if (strpos($retour, '|')) {
			list($this->codeRetour, $this->iua, $this->md5DocName) = explode('|', $retour);
		} else {
			$this->codeRetour = $retour;
		}
	}

	/**
	 * @return String
	 */
	public function getDocName()
	{
		return $this->docName;
	}

	/**
	 * @return String
	 */
	public function getMd5DocName()
	{
		return $this->md5DocName;
	}

	/**
	 * @return String
	 */
	public function getTargetDir()
	{
		return $this->targetDir;
	}

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_PUT;
	}
}
