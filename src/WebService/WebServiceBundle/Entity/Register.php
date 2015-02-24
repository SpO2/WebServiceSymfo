<?php

namespace WebService\WebServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WebService\WebServiceBundle\Entity\BaseEntity;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * @ORM\Entity
 * @ORM\Table(name="register")
 */
class Register extends BaseEntity 
{
	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"ById"})
	 */
	private $level;
	/**
	 * @ORM\Column(type="string")
	 * @Groups({"ById"})
	 */
	private $rang;
	/**
	 * @ORM\ManyToOne(targetEntity="Guild", inversedBy="register")
	 * @ORM\JoinColumn(name="guild_id", referencedColumnName="id")
	 * @Groups({"ById"})
	 * @MaxDepth(2)
	 */
	private $guild;
	/**
	 * @ORM\ManyToOne(targetEntity="Perso", inversedBy="register")
	 * @ORM\JoinColumn(name="perso_id", referencedColumnName="id")
	 * @Groups({"ById"})
	 * @MaxDepth(2)
	 */
	private $perso;
	
	public function getLevel() 
	{
		return $this->level;
	}
	public function setLevel($level) 
	{
		$this->level = $level;
		return $this;
	}
	public function getRang() 
	{
		return $this->rang;
	}
	public function setRang($rang) 
	{
		$this->rang = $rang;
		return $this;
	}
	public function getGuild() {
		return $this->guild;
	}
	public function setGuild($guild) {
		$this->guild = $guild;
		return $this;
	}
	public function getPerso() {
		return $this->perso;
	}
	public function setPerso($perso) {
		$this->perso = $perso;
		return $this;
	}
	
	
	
	
}