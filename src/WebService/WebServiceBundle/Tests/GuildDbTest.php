<?php

namespace WebService\WebServiceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use WebService\WebServiceBundle\Entity\Guild;

class GuildDbTest extends WebTestCase
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
	
	public function newGuild()
	{
		$em = $this->getEntityManager();
		$guild = new Guild();
		$guild->setBanner('banner');
		$guild->setName('guild');
		$em->persist($guild);
		$em->flush();
		return $guild;
	}
	
	public function testCreateGuild()
	{
		$em = $this->getEntityManager();
		$guild = $this->newGuild();
		$testGuild = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->find($guild->getId());
		$this->assertEquals($guild, $testGuild);
	}
	
	public function testFields()
	{
		$em = $this->getEntityManager();
		$em = $this->getEntityManager();
		$guild = $this->newGuild();
		$testGuild = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->find($guild->getId());
		$count = 0;
		if ((!empty($testGuild->getName())) && ($testGuild->getName() == 'guild')){
			$count++;
		}
		if ((!empty($testGuild->getBanner())) && ($testGuild->getBanner() == 'banner')){
			$count++;
		}
		if(!empty($testGuild->getCreatedAt()) && ($testGuild->getCreatedAt() != '')){
			$count++;
		}
		if(!empty($testGuild->getUpdatedAt()) && ($testGuild->getUpdatedAt() != '')){
			$count++;
		}
		$this->assertEquals($count, 4);
	}
	
	public function testUpdateGuild()
	{
		$em = $this->getEntityManager();
		$guild = $this->newGuild();
		$guild->setName('Guealdeux');
		$em->persist($guild);
		$em->flush();
		$testGuild = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->find($guild->getId());
		$this->assertEquals($guild, $testGuild);
	}
	
	public function testDeleteGuild()
	{
		$em = $this->getEntityManager();
		$guild = $this->newGuild();
		$saveId = $guild->getId();
		$em->remove($guild);
		$em->flush();
		$testGuild = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->find($saveId);
		$this->assertNull($testGuild);
	}
}