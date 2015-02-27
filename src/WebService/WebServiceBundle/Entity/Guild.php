<?php

namespace WebService\WebServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WebService\WebServiceBundle\Entity\BaseEntity;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 * @ORM\Table(name="guild")
 */
class Guild extends BaseEntity 
{
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"Default","ById"})
	 */
	private $name;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Groups({"Default","ById"})
	 */
	private $banner;
	/**
	 * @ORM\OneToMany(targetEntity="Register", mappedBy="guild")
	 * @Groups({"ById"})
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
	public function getBanner() 
	{
		return $this->banner;
	}
	public function setBanner($banner) 
	{
		$this->banner = $banner;
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