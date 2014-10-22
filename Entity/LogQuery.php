<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Consoneo\Bundle\ECoffreBundle\Entity\LogQuery
 *
 * @ORM\Table(name="ECoffreFortLogQuery")
 * @ORM\Entity()
 */
class LogQuery
{
	const QUERY_PUT     =   'PUT';
	const QUERY_GET     =   'GET';
	const QUERY_DEL     =   'DEL';
    const QUERY_CERT    =   'CERTIFICAT';

	private $labelReturnCode = [
		self::QUERY_PUT =>  [
			'0'     =>  'Le fichier a été déposé avec succès',
			'-1'    =>  'Emetteur non reconnu',
			'-2'    =>  'Identifiant coffre non valide',
			'-3'    =>  'Coffre résilié',
			'-4'    =>  'Coffre bloqué',
			'-5'    =>  'PART_ID invalide',
			'-6'    =>  'Le MD5 du fichier ne correspond pas à celui indiqué dans ma zone DOCMD5',
			'-7'    =>  'Dépassement de capacité du coffre',
			'-8'    =>  'Type de fichier non autorisé',
			'-9'    =>  'Fichier non déposé (erreur interne).',
		],
		self::QUERY_GET =>  [
			'0'     =>  'L’archive a été récupérée',
			'-1'    =>  'Erreur d’encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
			'-2'    =>  'PART_ID manquant',
			'-3'    =>  'IUA manquant',
			'-4'    =>  '(non utilisé)',
			'-5'    =>  'PART_ID incorrect',
			'-6'    =>  'Trop d’essais infructueux (mot de passe ou identifiant erroné)',
			'-7'    =>  'Accès non réalisé en SSL',
			'-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
			'-9'    =>  'Aucun fichier n’a été trouvé avec cet IUA',
			'-10'   =>  'Erreur interne',
		],
		self::QUERY_DEL =>  [
			'0'     =>  'L’archive a été supprimée',
			'-1'    =>  'Erreur d’encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
			'-2'    =>  'PART_ID manquant',
			'-3'    =>  'IUA manquant',
			'-4'    =>  '(non utilisé)',
			'-5'    =>  'PART_ID incorrect',
			'-6'    =>  'Trop d’essais infructueux (mot de passe ou identifiant erroné)',
			'-7'    =>  'Accès non réalisé en SSL',
			'-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
			'-9'    =>  'Aucun fichier n’a été trouvé avec cet IUA',
			'-10'   =>  'Erreur interne',
		],
        self::QUERY_CERT    =>  [
            '0'     =>  'Le certificat de conformité a été récupérée',
            '-1'    =>  'Erreur d’encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
            '-2'    =>  'PART_ID manquant',
            '-3'    =>  'IUA manquant',
            '-4'    =>  '(non utilisé)',
            '-5'    =>  'PART_ID incorrect',
            '-6'    =>  'Trop d’essais infructueux (mot de passe ou identifiant erroné)',
            '-7'    =>  'Accès non réalisé en SSL',
            '-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
            '-9'    =>  'Aucun fichier n’a été trouvé avec cet IUA',
            '-10'   =>  'Erreur interne',
            '-11'   =>  'Erreur interne HASH',
        ]
	];

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
	private $safeId;

	/**
	 * @ORM\Column(type="string")
	 */
	private $queryType;

	/**
	 * @ORM\Column(type="string")
	 */
	private $iua;

	/**
	 * @ORM\Column(type="string", length=3)
	 */
	private $returnCode;

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
     * @return LogQuery
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
     * Set queryType
     *
     * @param string $queryType
     * @return LogQuery
     */
    public function setQueryType($queryType)
    {
        $this->queryType = $queryType;

        return $this;
    }

    /**
     * Get queryType
     *
     * @return string 
     */
    public function getQueryType()
    {
        return $this->queryType;
    }

    /**
     * Set iua
     *
     * @param string $iua
     * @return LogQuery
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
     * Set returnCode
     *
     * @param string $returnCode
     * @return LogQuery
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    /**
     * Get returnCode
     *
     * @return string 
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

	public function getLabelReturnCode()
	{
		return $this->labelReturnCode[$this->getQueryType()][$this->getReturnCode()];
	}
}
