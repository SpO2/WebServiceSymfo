<?php

namespace WebService\WebServiceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use WebService\WebServiceBundle\Entity\Boot;

class BootDbTest extends WebTestCase{
	
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
	
	public function newBoot()
	{
		$em = $this->getEntityManager();
		$boot = new Boot();
		$boot->setLevel(1);
		$boot->setName('boot');
		$boot->setRarity('rare');
		$boot->setWeight('12');
		$em->persist($boot);
		$em->flush();
		return $boot;
	}
	
	public function testCreateBoot()
	{
		$em = $this->getEntityManager();
		$boot = $this->newBoot();
		$testBoot = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
			->find($boot->getId());
		$this->assertEquals($boot, $testBoot);
	}
	
	public function testUpdateBoot()
	{
		$em = $this->getEntityManager();
		$boot = $this->newBoot();
		$boot->setName('chaussure');
		$em->persist($boot);
		$em->flush();
		$testBoot = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
			->find($boot->getId());
		$this->assertEquals($boot->getName(), $testBoot->getName());
	}
	
	public function testDeleteBoot()
	{
		$em = $this->getEntityManager();
		$boot = $this->newBoot();
		$saveId = $boot->getId();
		$em->remove($boot);
		$em->flush();
		$testBoot = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
			->find($saveId);
		$this->assertNull($testBoot);
	}
}