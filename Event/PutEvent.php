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

	/**
	 * @var String
	 */
	private $md5Type;

	/**
	 * @var String
	 */
	private $fileSize;

	/**
	 * @var String
	 */
	private $fileDate;

	/**
	 * @var String
	 */
	private $fileTime;


	public function __construct($serviceType, $safeRoom = null, $docName, $safeId, $targetDir = null, $retour)
	{
		$this->serviceType  =   $serviceType;
		$this->docName      =   $docName;
		$this->targetDir    =   $targetDir;
		$this->safeId       =   $safeId;
		$this->safeRoom     =   $safeRoom;
		if (strpos($retour, '|')) {
			if ($this->serviceType == LogQuery::TA) {
				list($this->codeRetour, $this->iua, $this->docName, $this->md5DocName, $this->md5Type, $this->fileSize, $this->fileDate, $this->fileTime) = explode('|', $retour);
			} else {
				list($this->codeRetour, $this->iua, $this->md5DocName) = explode('|', $retour);
			}
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

	/**
	 * @return String
	 */
	public function getMd5Type()
	{
		return $this->md5Type;
	}

	/**
	 * @param String $md5Type
	 * @return PutEvent
	 */
	public function setMd5Type($md5Type)
	{
		$this->md5Type = $md5Type;
		return $this;
	}

	/**
	 * @return String
	 */
	public function getFileSize()
	{
		return $this->fileSize;
	}

	/**
	 * @param String $fileSize
	 * @return PutEvent
	 */
	public function setFileSize($fileSize)
	{
		$this->fileSize = $fileSize;
		return $this;
	}

	/**
	 * @return String
	 */
	public function getFileDate()
	{
		return $this->fileDate;
	}

	/**
	 * @param String $fileDate
	 * @return PutEvent
	 */
	public function setFileDate($fileDate)
	{
		$this->fileDate = $fileDate;
		return $this;
	}

	/**
	 * @return String
	 */
	public function getFileTime()
	{
		return $this->fileTime;
	}

	/**
	 * @param String $fileTime
	 * @return PutEvent
	 */
	public function setFileTime($fileTime)
	{
		$this->fileTime = $fileTime;
		return $this;
	}
}
