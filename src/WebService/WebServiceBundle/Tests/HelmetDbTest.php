<?php

namespace WebService\WebServiceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use WebService\WebServiceBundle\Entity\Helmet;

class HelmetDbTest extends WebTestCase
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
	
	public function newHelmet()
	{
		$em = $this->getEntityManager();
		$helmet = new Helmet();
		$helmet->setLevel(1);
		$helmet->setName('Helmet');
		$helmet->setRarity('rare');
		$helmet->setWeight('12');
		$em->persist($helmet);
		$em->flush();
		return $helmet;
	}
	
	public function testCreateHelmet()
	{
		$em = $this->getEntityManager();
		$helmet = $this->newHelmet();
		$testHelmet = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
			->find($helmet->getId());
		$this->assertEquals($helmet, $testHelmet);
	}
	
	public function testUpdateHelmet()
	{
		$em = $this->getEntityManager();
		$helmet = $this->newHelmet();
		$helmet->setName('casque');
		$em->persist($helmet);
		$em->flush();
		$testHelmet = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
			->find($helmet->getId());
		$this->assertEquals($helmet->getName(), $testHelmet->getName());
	}
	
	public function testDeleteHelmet()
	{
		$em = $this->getEntityManager();
		$helmet = $this->newHelmet();
		$saveId = $helmet->getId();
		$em->remove($helmet);
		$em->flush();
		$testHelmet = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
		->find($saveId);
		$this->assertNull($testHelmet);
	}
}