<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Consoneo\Bundle\ECoffreBundle\Entity\LogQuery
 *
 * @ORM\Table(name="ECoffreFortAnnuaire")
 * @ORM\Entity()
 */
class Annuaire
{
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="create")
	 */
	private $createdDateTime;

	/**
	 * @ORM\Column(type="string")
	 */
	private $iua;

	/**
	 * @ORM\Column(type="string")
	 */
	private $safeId;

	/**
	 * @ORM\Column(type="string")
	 */
	private $docName;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $targetDir;

	/**
	 * @ORM\Column(type="string")
	 */
	private $md5DocName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $serviceType;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdDateTime
     *
     * @param \DateTime $createdDateTime
     * @return Annuaire
     */
    public function setCreatedDateTime($createdDateTime)
    {
        $this->createdDateTime = $createdDateTime;

        return $this;
    }

    /**
     * Get createdDateTime
     *
     * @return \DateTime 
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * Set iua
     *
     * @param string $iua
     * @return Annuaire
     */
    public function setIua($iua)
    {
        $this->iua = $iua;

        return $this;
    }

    /**
     * Get iua
     *
     * @return string 
     */
    public function getIua()
    {
        return $this->iua;
    }

    /**
     * Set docName
     *
     * @param string $docName
     * @return Annuaire
     */
    public function setDocName($docName)
    {
        $this->docName = $docName;

        return $this;
    }

    /**
     * Get docName
     *
     * @return string 
     */
    public function getDocName()
    {
        return $this->docName;
    }

    /**
     * Set targetDir
     *
     * @param string $targetDir
     * @return Annuaire
     */
    public function setTargetDir($targetDir)
    {
        $this->targetDir = $targetDir;

        return $this;
    }

    /**
     * Get targetDir
     *
     * @return string 
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    /**
     * Set md5DocName
     *
     * @param string $md5DocName
     * @return Annuaire
     */
    public function setMd5DocName($md5DocName)
    {
        $this->md5DocName = $md5DocName;

        return $this;
    }

    /**
     * Get md5DocName
     *
     * @return string 
     */
    public function getMd5DocName()
    {
        return $this->md5DocName;
    }

	/**
	 * Set safeId
	 *
	 * @param string $safeId
	 * @return LogQuery
	 */
	public function setSafeId($safeId)
	{
		$this->safeId = $safeId;

		return $this;
	}

	/**
	 * Get safeId
	 *
	 * @return string
	 */
	public function getSafeId()
	{
		return $this->safeId;
	}

	/**
	 * @return string
	 */
	public function getServiceType()
	{
		return $this->serviceType;
	}

	/**
	 * @param string $serviceType
	 * @return Annuaire
	 */
	public function setServiceType($serviceType)
	{
		$this->serviceType = $serviceType;
		return $this;
	}

}
