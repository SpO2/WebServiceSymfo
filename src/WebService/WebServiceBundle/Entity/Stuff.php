<?php

namespace WebService\WebServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WebService\WebServiceBundle\Entity\BaseEntity;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JsonSchema\Constraints\String;

/**
 * Stuff Entity - Base class for stuff elements.
 * 
 * @author romain
 * @package src\Entity
 * @ORM\Entity
 * @ORM\Table(name="stuff")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
class Stuff extends BaseEntity 
{
	/**
	 * The name of the stuff.
	 * @var \String.
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"Default","ById", "StuffById"})
	 */
	private $name;
	/**
	 * The perso that owns the stuff.
	 * @var Perso.
	 * @ORM\ManyToOne(targetEntity="Perso", inversedBy="stuff")
	 * @ORM\JoinColumn(name="perso_id", referencedColumnName="id")
	 * @Groups({"ById", "StuffById"})
	 */
	private $perso;
	/**
	 * The rarity of the stuff.
	 * @var \String.
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"ById", "StuffById"})
	 */
	private $rarity;
	/**
	 * The level of the stuff.
	 * @var \Integer.
	 * @ORM\Column(type="integer")
	 * @Groups({"Default","ById", "StuffById"})
	 */
	private $level;
	/**
	 * The weight of the stuff.
	 * @var \Integer.
	 * @ORM\Column(type="integer")
	 * @Groups({"Default","ById", "StuffById"})
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
		return $this->rarity;
	}
	public function setRarity($rarity) {
		$this->rarity = $rarity;
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
