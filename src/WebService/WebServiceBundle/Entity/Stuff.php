<?php

namespace WebService\WebServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WebService\WebServiceBundle\Entity\BaseEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="stuff")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
class Stuff extends BaseEntity 
{
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $name;
	/**
	 * @ORM\ManyToOne(targetEntity="Perso", inversedBy="stuff")
	 * @ORM\JoinColumn(name="perso_id", referencedColumnName="id")
	 */
	private $perso;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $Rarity;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $level;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $weight;
	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getPerso() {
		return $this->perso;
	}
	public function setPerso($perso) {
		$this->perso = $perso;
		return $this;
	}
	public function getRarity() {
		return $this->Rarity;
	}
	public function setRarity($Rarity) {
		$this->Rarity = $Rarity;
		return $this;
	}
	public function getLevel() {
		return $this->level;
	}
	public function setLevel($level) {
		$this->level = $level;
		return $this;
	}
	public function getWeight() {
		return $this->weight;
	}
	public function setWeight($weight) {
		$this->weight = $weight;
		return $this;
	}
	
}