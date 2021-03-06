<?php

namespace WebService\WebServiceBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use WebService\WebServiceBundle\Entity\Perso;

class PersoDbTest extends WebTestCase 
{
	private $em;
	
	public function __construct()
	{
		self::bootKernel();
		$this->em =  static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
	}
	
	protected function getEntityManager()
	{
		return $this->em;
	}
	
	protected function newUser()
	{
		$em = $this->getEntityManager();
		$perso = new Perso();
		$perso->setName('Toto');
		$perso->setLevel(1);
		$perso->setClass('class');
		$perso->setRace('race');
		$perso->setSexe('sexe');
		$em->persist($perso);
		$em->flush();
		return $perso;
	}
	
	public function testNewPerso()
	{
		$em = $this->getEntityManager();
		$perso = $this->newUser();
		
		$testPerso = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
			->find($perso->getId());
		$this->assertEquals($perso, $testPerso) ;
	}
	
	public function testFields()
	{
		$em = $this->getEntityManager();
		$perso = $this->newUser();
		$testPerso = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
		->find($perso->getId());
		$count = 0;
		if(!empty($testPerso->getName()) && ($testPerso->getName() == 'Toto')){
			$count++;
		}
		if(!empty($testPerso->getClass()) && ($testPerso->getClass() == 'class')){
			$count++;
		}
		if(!empty($testPerso->getRace()) && ($testPerso->getRace() == 'race')){
			$count++;
		}
		if(!empty($testPerso->getSexe()) && ($testPerso->getSexe() == 'sexe')){
			$count++;
		}
		if(!empty($testPerso->getLevel()) && ($testPerso->getLevel() == 1)){
			$count++;
		}
		if(!empty($testPerso->getCreatedAt()) && ($testPerso->getCreatedAt() != '')){
			$count++;
		}
		if(!empty($testPerso->getUpdatedAt()) && ($testPerso->getUpdatedAt() != '')){
			$count++;
		}
		$this->assertEquals($count, 7);
	}
	
	public function testUpdatePerso()
	{
		$em = $this->getEntityManager();
		$perso = $this->newUser();
		$perso->setName('Tutu');
		$em->persist($perso);
		$em->flush();
		$testPerso = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
			->find($perso->getId());		
		$this->assertEquals($perso->getName(), $testPerso->getName());
	}
	
	public function testDeletePerso()
	{
		$em = $this->getEntityManager();
		$perso = $this->newUser();
		$saveId = $perso->getId();
		$em->remove($perso);
		$em->flush();
		$testPerso = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
			->find($saveId);
		$this->assertNull($testPerso);
	}
}