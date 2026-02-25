<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Table(name: 'ECoffreFortLogQuery')]
#[ORM\Entity]
class LogQuery
{
	const QUERY_PUT         =   'PUT';
	const QUERY_GET         =   'GET';
	const QUERY_DEL         =   'DEL';
	const QUERY_CERT        =   'CERTIFICAT';
	const QUERY_MOVE        =   'MOVE';
	const QUERY_LIST        =   'LIST';
	const QUERY_GETPROP     =   'GETPROP';
	const QUERY_SAFEGETPROP =   'SAFEGETPROP';

	const COFFRE            =   'coffre';
	const TA                =   'tiersArchivage';

	public static array $labelReturnCode = [
		self::COFFRE    =>  [
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
				'0'     =>  'L'archive a été récupérée',
				'-1'    =>  'Erreur d'encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
				'-2'    =>  'PART_ID manquant',
				'-3'    =>  'IUA manquant',
				'-4'    =>  '(non utilisé)',
				'-5'    =>  'PART_ID incorrect',
				'-6'    =>  'Trop d'essais infructueux (mot de passe ou identifiant erroné)',
				'-7'    =>  'Accès non réalisé en SSL',
				'-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
				'-9'    =>  'Aucun fichier n'a été trouvé avec cet IUA',
				'-10'   =>  'Erreur interne',
			],
			self::QUERY_DEL =>  [
				'0'     =>  'L'archive a été supprimée',
				'-1'    =>  'Erreur d'encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
				'-2'    =>  'PART_ID manquant',
				'-3'    =>  'IUA manquant',
				'-4'    =>  '(non utilisé)',
				'-5'    =>  'PART_ID incorrect',
				'-6'    =>  'Trop d'essais infructueux (mot de passe ou identifiant erroné)',
				'-7'    =>  'Accès non réalisé en SSL',
				'-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
				'-9'    =>  'Aucun fichier n'a été trouvé avec cet IUA',
				'-10'   =>  'Erreur interne',
			],
			self::QUERY_CERT    =>  [
				'0'     =>  'Le certificat de conformité a été récupérée',
				'-1'    =>  'Erreur d'encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
				'-2'    =>  'PART_ID manquant',
				'-3'    =>  'IUA manquant',
				'-4'    =>  '(non utilisé)',
				'-5'    =>  'PART_ID incorrect',
				'-6'    =>  'Trop d'essais infructueux (mot de passe ou identifiant erroné)',
				'-7'    =>  'Accès non réalisé en SSL',
				'-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
				'-9'    =>  'Aucun fichier n'a été trouvé avec cet IUA',
				'-10'   =>  'Erreur interne',
				'-11'   =>  'Erreur interne HASH',
			],
			self::QUERY_MOVE    =>  [
				'0'     =>  'Opération réalisée avec succès',
				'-1'    =>  'Erreur d'encodage la valeur YY est incorrecte (elle différentes dans les deux zones.',
				'-2'    =>  'PART_ID manquant',
				'-3'    =>  'IUA manquant',
				'-4'    =>  '(non utilisé)',
				'-5'    =>  'PART_ID incorrect',
				'-6'    =>  'Trop d'essais infructueux (mot de passe ou identifiant erroné)',
				'-7'    =>  'Accès non réalisé en SSL',
				'-8'    =>  'Identification erronée (Identifiant ou mot de passe erroné)',
				'-9'    =>  'Aucun fichier n'a été trouvé avec cet IUA',
				'-10'   =>  'Erreur interne',
				'-11'   =>  'DEST Manquant',
				'-12'   =>  'Erreur impossible de déplacer le fichier',
				'-99'   =>  'Service fermé',
			],
		],
		self::TA    =>  [
			self::QUERY_PUT         =>  [
				'0'     =>  'l'objet a été versé avec succès',
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-7'    =>  'Type de HASH non supporté',
				'-8'    =>  'Objet à verser manquant',
				'-9'    =>  'Le HASH recalculé est différent de celui transmis avec l'objet à archiver',
				'-10'   =>  'Erreur interne',
				'-11'   =>  'Erreur interne',
				'-12'   =>  'Dépassement de capacité du coffre',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
			self::QUERY_GET         =>  [
				'0'     =>  'Archive récupérée avec succès',
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-7'    =>  'Archive manquante',
				'-8'    =>  'Erreur interne',
				'-9'    =>  'Archive corrompue',
				'-11'   =>  'Erreur interne',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
			self::QUERY_CERT        =>  [
				'0'     =>  'Certificat de conformité récupéré avec succès',
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-7'    =>  'Archive manquante',
				'-8'    =>  'Erreur interne',
				'-9'    =>  'Archive corrompue',
				'-11'   =>  'Erreur interne',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
			self::QUERY_LIST        =>  [
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-7'    =>  'Aucune archive disponible',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
			self::QUERY_DEL         =>  [
				'0'     =>  'Archive supprimée avec succès',
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-7'    =>  'Archive manquante',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
			self::QUERY_GETPROP     =>  [
				'0'     =>  'Propriétés de l'archive récupérées avec succès',
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-7'    =>  'Archive manquante',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
			self::QUERY_SAFEGETPROP =>  [
				'0'     =>  'Propriétés de l'archive récupérées avec succès',
				'-1'    =>  'SafeRoom non valide',
				'-2'    =>  'Identifiant du coffre non valide',
				'-3'    =>  'Coffre supprimé',
				'-4'    =>  'Coffre bloqué',
				'-5'    =>  'Identifiant d'utilisateur erroné',
				'-6'    =>  'Utilisateur non autorisé',
				'-15'   =>  'Service non opérationnel',
				'-16'   =>  'Paramètres manquants',
				'-17'   =>  'Erreur interne',
			],
		]
	];

	#[ORM\Column(name: 'id', type: Types::INTEGER)]
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: 'AUTO')]
	private ?int $id = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
	#[Gedmo\Timestampable(on: 'create')]
	private ?\DateTime $createdDateTime = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $safeId = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $queryType = null;

	#[ORM\Column(type: Types::STRING, nullable: true)]
	private ?string $iua = null;

	#[ORM\Column(type: Types::STRING, length: 3)]
	private ?string $returnCode = null;

	#[ORM\Column(type: Types::STRING, nullable: true)]
	private ?string $serviceType = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setCreatedDateTime(?\DateTime $createdDateTime): static
	{
		$this->createdDateTime = $createdDateTime;

		return $this;
	}

	public function getCreatedDateTime(): ?\DateTime
	{
		return $this->createdDateTime;
	}

	public function setSafeId(?string $safeId): static
	{
		$this->safeId = $safeId;

		return $this;
	}

	public function getSafeId(): ?string
	{
		return $this->safeId;
	}

	public function setQueryType(?string $queryType): static
	{
		$this->queryType = $queryType;

		return $this;
	}

	public function getQueryType(): ?string
	{
		return $this->queryType;
	}

	public function setIua(?string $iua): static
	{
		$this->iua = $iua;

		return $this;
	}

	public function getIua(): ?string
	{
		return $this->iua;
	}

	public function setReturnCode(?string $returnCode): static
	{
		$this->returnCode = $returnCode;

		return $this;
	}

	public function getReturnCode(): ?string
	{
		return $this->returnCode;
	}

	public function getServiceType(): ?string
	{
		return $this->serviceType;
	}

	public function setServiceType(?string $serviceType): static
	{
		$this->serviceType = $serviceType;

		return $this;
	}

	public function getLabelReturnCode(): string
	{
		return static::$labelReturnCode[$this->getServiceType()][$this->getQueryType()][$this->getReturnCode()] ?? '';
	}
}
