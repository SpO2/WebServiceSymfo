<?php

namespace WebService\WebServiceBundle\Entity;

use WebService\WebServiceBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Component\Config\Definition\IntegerNode;

/**
 * @ORM\Entity
 * @ORM\Table(name="perso")
 * @ExclusionPolicy("All")
 */
class Perso extends BaseEntity 
{
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Expose()
	 * @Groups({"Default", "ById", "StuffById"})
	 */
	private $name;
	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"Default", "ById", "StuffById"})
	 * @Expose()
	 */
	private $level;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"Default", "ById", "StuffById"})
	 * @Expose()
	 */
	private $class;
	/**
	 * @ORM\OneToMany(targetEntity="Stuff", mappedBy="perso")
	 * @Expose()
	 * @Groups({"ById"})
	 */
	private $stuff;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"Default", "ById", "StuffById"})
	 * @Expose()
	 */
	private $race;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"Default", "ById", "StuffById"})
	 * @Expose()
	 */
	private $sexe;
	
	/**
	 * @ORM\OneToMany(targetEntity="Register", mappedBy="perso")
	 * @Groups({"ById"})
	 * @Expose()
	 */
	private $register;
	
	/**
	 * 
	 * @var integer
	 * @ORM\ManyToOne(targetEntity="Perso", inversedBy="contact")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	private $parent;
	
	/**
	 * 
	 * @var Integer
	 * @ORM\OneToMany(targetEntity="Perso", mappedBy="parent")
	 * @Expose()
	 * @Groups({"ById"})
	 * @MaxDepth(2)
	 */
	private $contact;
	
	
	public function __construct(){
		$this->setContact(new \Doctrine\Common\Collections\ArrayCollection());
	}
	
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
	public function getParent() {
		return $this->parent;
	}
	
	public function setParent($parent) {
		$this->parent = $parent;
		return $this;
	}
	
	public function getContact() {
		return $this->contact;
	}
	
	public function setContact($contact) {
		$this->contact = $contact;
		return $this;
	}	
	
	public function __toString(){
		return $this->name;
	}
	
}