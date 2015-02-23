<?php

namespace WebService\WebServiceBundle\Entity;

use WebService\WebServiceBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="perso")
 */
class Perso extends BaseEntity 
{
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $name;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $level;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $class;
	/**
	 * @ORM\OneToMany(targetEntity="Stuff", mappedBy="perso")
	 */
	private $stuff;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $race;
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $sexe;
	
	/**
	 * @ORM\OneToMany(targetEntity="Register", mappedBy="perso")
	 */
	private $register;
	
	public function getName()
	 {
		return $this->name;
	}
	public function setName($name) 
	{
		$this->name = $name;
		return $this;
	}
	
	public function getLevel() 
	{
		return $this->level;
	}
	public function setLevel($level) 
	{
		$this->level = $level;
		return $this;
	}
	
	public function getClass() 
	{
		return $this->class;
	}
	public function setClass($class) 
	{
		$this->class = $class;
		return $this;
	}
	
	public function getRace() 
	{
		return $this->race;
	}
	public function setRace($race) 
	{
		$this->race = $race;
		return $this;
	}
	
	public function getSexe() 
	{
		return $this->sexe;
	}
	public function setSexe($sexe) 
	{
		$this->sexe = $sexe;
		return $this;
	}
	public function getStuff() {
		return $this->stuff;
	}
	public function setStuff($stuff) {
		$this->stuff = $stuff;
		return $this;
	}
	public function getRegister() {
		return $this->register;
	}
	public function setRegister($register) {
		$this->register = $register;
		return $this;
	}
	
	
	public function __toString(){
		return $this->name;
	}
	
}