<?php

namespace WebService\WebServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;

/**
 * Base Entity to extend.
 * @author romain
 * @package src\Entity
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
class BaseEntity 
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @Groups({"Default", "ById"})
	 * @Expose
	 */
	protected $id;
	/**
	 * @ORM\Column(type="datetime")
	 * @Expose
	 * @Groups({"Default", "ById"})
	 */
	protected $createdAt;
	/**
	 * @ORM\Column(type="datetime")
	 * @Expose
	 * @Groups({"Default", "ById"})
	 */
	protected $updatedAt;
	
	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	
	
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
	/**
	 * Set createdAt
	 *
	 * @ORM\PrePersist
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
	}
	
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
	/**
	 * Set updatedAt
	 *
	 * @ORM\PreUpdate
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = new \DateTime();
	}
}