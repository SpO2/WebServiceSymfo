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