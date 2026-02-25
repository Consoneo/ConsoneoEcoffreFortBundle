<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Table(name: 'ECoffreFortAnnuaire')]
#[ORM\Entity]
class Annuaire
{
	#[ORM\Column(name: 'id', type: Types::INTEGER)]
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: 'AUTO')]
	private ?int $id = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
	#[Gedmo\Timestampable(on: 'create')]
	private ?\DateTime $createdDateTime = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $iua = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $safeId = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $docName = null;

	#[ORM\Column(type: Types::STRING, nullable: true)]
	private ?string $targetDir = null;

	#[ORM\Column(type: Types::STRING)]
	private ?string $md5DocName = null;

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

	public function setIua(?string $iua): static
	{
		$this->iua = $iua;

		return $this;
	}

	public function getIua(): ?string
	{
		return $this->iua;
	}

	public function setDocName(?string $docName): static
	{
		$this->docName = $docName;

		return $this;
	}

	public function getDocName(): ?string
	{
		return $this->docName;
	}

	public function setTargetDir(?string $targetDir): static
	{
		$this->targetDir = $targetDir;

		return $this;
	}

	public function getTargetDir(): ?string
	{
		return $this->targetDir;
	}

	public function setMd5DocName(?string $md5DocName): static
	{
		$this->md5DocName = $md5DocName;

		return $this;
	}

	public function getMd5DocName(): ?string
	{
		return $this->md5DocName;
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

	public function getServiceType(): ?string
	{
		return $this->serviceType;
	}

	public function setServiceType(?string $serviceType): static
	{
		$this->serviceType = $serviceType;

		return $this;
	}
}
