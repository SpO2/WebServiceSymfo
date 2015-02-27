<?php

namespace WebService\WebServiceBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use WebService\WebServiceBundle\Entity\Perso;
use WebService\WebServiceBundle\Entity\Guild;
use WebService\WebServiceBundle\Entity\Boot;
use WebService\WebServiceBundle\Entity\Helmet;
use WebService\WebServiceBundle\Entity\Register;
use WebService\WebServiceBundle\Form\RegisterType;
use WebService\WebServiceBundle\Form\PersoType;
use WebService\WebServiceBundle\Form\StuffType;
use WebService\WebServiceBundle\Form\BootType;
use WebService\WebServiceBundle\Form\GuildType;
use JMS\Serializer\SerializationContext;

class DefaultRestController extends FOSRestController {
	
	/**
	 * Get all the perso from the database without linked resources.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Rest\Get("perso")
	 * @ApiDoc(
	 *   section="Perso entity",
	 *   description="Get all perso from database.", 
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not Found"
	 *   }
	 *)
	 */
	public function getAllPersoAction(){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
			->findAll();
		if ($data){
			$view = $this->view(array("persos" => $data),200);
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}		
		$view->setSerializationContext(SerializationContext::create()->setGroups(['Default']));
		return $this->handleView($view);
	}	
	
	/**
	 * Get a perso by his Id, with the linked resources. MaxDepht = 1.
	 * @Rest\Get("perso/{id}")
	 * @param integer $id Id of the perso instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   section="Perso entity",
	 *   description="Get perso from database by ID." ,
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not Found"
	 *   }
	 * )
	 */
	public function getPersoByIdAction($id){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
			->findOneById($id);
		if($data){
			$view = $this->view(array("perso" => $data),200);
			$view->setSerializationContext(SerializationContext::create()->setGroups(['ById'])->enableMaxDepthChecks());
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		return $this->handleView($view);
	}
	
	/**
	 * Insert a perso in the database.
	 * @Rest\Put("perso")
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Put perso in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "OK|KO",
	 *   		"description" = "The name of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "class",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Bretteur|Magicien|Archer",
	 *   		"description" = "The class of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "race",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Humain|Pneu",
	 *   		"description" = "The race of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "sexe",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Supérieur|Inférieur",
	 *   		"description" = "The sex of the perso"
	 *   	},
	 *   },
	 *   section="Perso entity",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *   	406 = "No Data"
	 *   }
	 * )
	 * 
	 */
	public function putPersoAction(){
		$em = $this->getDoctrine()->getManager();
		
		$entity = new Perso();
		
		$form = $this->createForm(new PersoType(),
				$entity, array('csrf_protection' => false));
		$request = $this->getRequest()->request->all();
		$form->submit($request);
		if($form->isValid()){
			$em->persist($entity);
			$em->flush();
		}
		
		if($entity->getId()>0){
			$view = $this->view(array("perso" => $entity),200);
		}else{
			$view = $this->view(array("message" => "No data"),406);
		}
		return $this->handleView($view);
	}
	
	/**
	 * Update a perso in the database.
	 * @Rest\Post("perso/{id}")
	 * @param integer $id Id of the perso instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Update perso in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "OK|KO",
	 *   		"description" = "The name of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "class",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Bretteur|Magicien|Archer",
	 *   		"description" = "The class of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "race",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Humain|Pneu",
	 *   		"description" = "The race of the perso"
	 *   	},
	 *   	{
	 *   		"name" = "sexe",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Supérieur|Inférieur",
	 *   		"description" = "The sex of the perso"
	 *   	},
	 *   },
	 *   section="Perso entity",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *      418 = "I’m a teapot",
	 *   	422 = "Unprocessable entity"
	 *   }
	 * )
	 * 
	 */
	public function postPersoAction($id){
		$em = $this->getDoctrine()->getManager();
	
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
			->findOneById($id);
		$beforeUpdate = $data->getUpdatedAt();
		if ($data){
			$form = $this->createForm(new PersoType(),
					$data, array('csrf_protection' => false));
			$request = $this->getRequest()->request->all();
			$form->submit($request);
			if($form->isValid()){
				$em->persist($data);
				$em->flush();
			}
			$dataAfterUpdate = $data = $em->getRepository('WebService\WebServiceBundle\Entity\Perso')
				->findOneById($id);
			if($dataAfterUpdate->getUpdatedAt() != $beforeUpdate){
				$view = $this->view(array("perso" => $dataAfterUpdate),200);
			}else{
				$view = $this->view(array("message" => "Update failed"),422);
			}
			
		}else{
			$view = $this->view(array("message" => "Entity not found"),418);
		}
		return $this->handleView($view);
	}

	/**
	 * Get all the guild from the database, without linked resources.
	 * @Rest\Get("guild")
	 * @ApiDoc(
	 *   section="Guild entity",
	 *   description="Get all guild from database.",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not found"
	 *   } 
	 * ) 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getAllGuildAction(){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->findAll();
		if ($data){
			$view = $this->view(array("guilds" => $data), 200);
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['Default']));
		return $this->handleView($view);
	}
	
	/**
	 * Get a guild from the database with her linked resources.
	 * @Rest\Get("guild/{id}")
	 * @param integer $id Id of the guild instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   section="Guild entity",
	 *   description="Get guild from database by ID.",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not found"
	 *   } 
	 * )
	 */
	public function getGuildByIdAction($id){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->findOneById($id);
		if($data){
			$view = $this->view(array("guild" => $data), 200);
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['ById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}

	/**
	 * Insert a guild in the database.
	 * @Rest\Put("guild")
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Put guild in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Guild",
	 *   		"description" = "The name of the guild."
	 *   	},
	 *   	{
	 *   		"name" = "banner",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Bannière",
	 *   		"description" = "The banner of the guild."
	 *   	}
	 *   },
	 *   section="Guild entity",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *   	406 = "Not Acceptable"
	 *   }
	 *)
	 */
	public function putGuildAction(){
		$em = $this->getDoctrine()->getManager();
		
		$entity = new Guild();
		$form = $this->createForm(new GuildType(),
				$entity, array('csrf_protection' => false));
		$request = $this->getRequest()->request->all();
		$form->submit($request);
		if($form->isValid()){
			$em->persist($entity);
			$em->flush();
		}
		if ($entity->getId() > 0){
			$view = $this->view(array("guild" => $entity),200);
		}else{
			$view = $this->view(array("message" => "No data"),406);
		}
		return $this->handleView($view);
	}

	/**
	 * Delete a guild from the database.
	 * @Rest\Post("guild/remove/{id}")
	 * @param integer $id Id of the guild instance.
	 * @ApiDoc(
	 *   description="Delete guild in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "id",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "Guild id",
	 *   		"description" = "The id of the guild."
	 *   	}
	 *   },
	 *   section="Guild entity",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *   	418 = "I’m a teapot",
	 *   	422 = "Unprocessable entity"
	 *   }
	 *)
	 */
	public function putRemoveGuildAction($id){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->findOneById($id);
		if ($data){
			$em->remove($data);
			$em->flush();
			$verifyData = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
				->findOneById($id);
			if ($verifyData){
				$view = $this->view(array("message" => "Delete failed"),422);
			}else{
				$view = $this->view(array("message" => "Entity deleted with success."),200);
			}
		}else{
			$view = $this->view(array("message" => "Entity not found"),418);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['ById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}
	
	/**
	 * Update a guild in the database.
	 * @Rest\Post("guild/{id}")
	 * @param integer $id Id of the guild instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Update guild in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Guild",
	 *   		"description" = "The name of the guild."
	 *   	},
	 *   	{
	 *   		"name" = "banner",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Bannière",
	 *   		"description" = "The banner of the guild."
	 *   	}
	 *   },
	 *   section="Guild entity",
	 *   statusCodes={
	 *   	200 = "Ok",
	 *   	418 = "I’m a teapot",
	 *   	422 = "Unprocessable entity"
	 *   }
	 *)
	 */
	public function postGuildAction($id){
		$em = $this->getDoctrine()->getManager();
		
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
			->findOneById($id);
		$beforeUpdate = $data->getUpdatedAt();
		if ($data){
			$form = $this->createForm(new GuildType(),
					$data, array('csrf_protection' => false));
			$request = $this->getRequest()->request->all();
			$form->submit($request);
			if($form->isValid()){
				$em->persist($data);
				$em->flush();
			}
			$dataAfterUpdate = $data = $em->getRepository('WebService\WebServiceBundle\Entity\Guild')
				->findOneById($id);
			if($dataAfterUpdate->getUpdatedAt() != $beforeUpdate){
				$view = $this->view(array("guild" => $dataAfterUpdate),200);
			}else{
				$view = $this->view(array("message" => "Update failed"),422);
			}
		}else{
			$view = $this->view(array("message" => "Entity not found"),418);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['ById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}

	/**
	 * Get all boot from the database, without linked resources.
	 * @Rest\Get("boot")
	 * @ApiDoc(
	 *   section="Boot entity",
	 *   description="Get all boot from database.",
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not found"
	 *   }
	 *)
	 */
	public function getAllBootAction(){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
			->findAll();
		if ($data){
			$view = $this->view(array("boots" => $data),200);
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['Default']));
		return $this->handleView($view);
	}

	/**
	 * Get a boot by her id, with linked resources.
	 * @Rest\Get("boot/{id}")
	 * @param integer $id Id of the boot instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   section="Boot entity",
	 *   description="Get boot from database by ID.",
	 *  statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not found"
	 *   }
	 * )
	 */
	public function getBootByIdAction($id){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
			->findOneById($id);
		if($data){
			$view = $this->view(array("boot" => $data),200);
			$view->setSerializationContext(SerializationContext::create()->setGroups(['StuffById'])->enableMaxDepthChecks());
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		return $this->handleView($view);
	}

	/**
	 * Insert a boot in the database.
	 * @Rest\Put("boot")
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Put boot in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Name of the stuff",
	 *   		"description" = "The name of the boots."
	 *   	},
	 *   	{
	 *   		"name" = "rarity",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Rarity of the stuff",
	 *   		"description" = "The rarity of the boots"
	 *   	},
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the boots"
	 *   	},
	 *   	{
	 *   		"name" = "weight",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..1000",
	 *   		"description" = "The weight of the boots"
	 *   	},
	 *   	{
	 *   		"name" = "perso",
	 *   		"dataType" = "Perso",
	 *   		"requirement" = "A valid perso",
	 *   		"description" = "The perso that holds the boots."
	 *   	}
	 *   },
	 * section="Boot entity",
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	406 = "Not Acceptable"
	 *   }
	 * )
	 *   
	 **/
	public function putBootAction(){
		$em = $this->getDoctrine()->getManager();
		
		$request = $this->getRequest()->request->all();
		
		$entity = new Boot();
		$form = $this->createForm(new StuffType(),
					$entity, array('csrf_protection' => false));
		$request = $this->getRequest()->request->all();
		$form->submit($request);
		if($form->isValid()){
			$em->persist($entity);
			$em->flush();
			if($entity->getId()>0){
				$view = $this->view(array("boot" => $entity),200);
			}else{
				$view = $this->view(array("message" => "No data"),406);
			}
		}else{
			$view = $this->view(array("message" => "Cannot Insert Data"),406);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['StuffById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}

	/**
	 * Update a boot in the database.
	 * @Rest\Post("boot/{id}")
	 * @param integer $id Id of the boot instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Update boot in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Name of the stuff",
	 *   		"description" = "The name of the boots."
	 *   	},
	 *   	{
	 *   		"name" = "rarity",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Rarity of the stuff",
	 *   		"description" = "The rarity of the boots"
	 *   	},
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the boots0"
	 *   	},
	 *   	{
	 *   		"name" = "weight",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..1000",
	 *   		"description" = "The weight of the boots"
	 *   	},
	 *   	{
	 *   		"name" = "perso",
	 *   		"dataType" = "Perso",
	 *   		"requirement" = "A valid perso",
	 *   		"description" = "The perso that holds the boots."
	 *   	}
	 *   },
	 * section="Boot entity",
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	418 = "I’m a teapot",
	 *   	422 = "Unprocessable entity"
	 *   }
	 * )
	 *
	 **/
	public function postBootAction($id){
		$em = $this->getDoctrine()->getManager();
		
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
			->findOneById($id);
		$beforeUpdate = $data->getUpdatedAt();
		if ($data){
			$form = $this->createForm(new StuffType(),
					$data, array('csrf_protection' => false));
			$request = $this->getRequest()->request->all();
			$form->submit($request);
			if($form->isValid()){
				$em->persist($data);
				$em->flush();
			}
			$dataAfterUpdate = $data = $em->getRepository('WebService\WebServiceBundle\Entity\Boot')
				->findOneById($id);
			if($dataAfterUpdate->getUpdatedAt() != $beforeUpdate){
				$view = $this->view(array("boot" => $dataAfterUpdate),200);
			}else{
				$view = $this->view(array("message" => "Update failed"),422);
			}
		}else{
			$view = $this->view(array("message" => "Entity not found"),418);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['StuffById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}
		
	/**
	 * Get all helmet from the database, without linked resources.
	 * @Rest\Get("helmet")
	 * @ApiDoc(
	 *   section="Helmet entity",
	 *   description="Get all helmet from database.",
	 *  statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not found"
	 *   } 
	 * )
	 */
	public function getAllHelmetAction(){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
			->findAll();
		if ($data){
			$view = $this->view(array("helmets" => $data),200);
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['Default']));
		return $this->handleView($view);
	}
	
	/**
	 * Get a helmet by his Id, with linked resources.
	 * @Rest\Get("helmet/{id}")
	 * @param integer $id Id of the helmet instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   section="Helmet entity",
	 *   description="Get helmet from database by ID.",
	 *  statusCodes={
	 *   	200 = "Ok",
	 *   	404 = "Not found"
	 *   } 
	 * )
	 */
	public function getHelmetByIdAction($id){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
			->findOneById($id);
		if($data){
			$view = $this->view(array("helmet" => $data),200);
			$view->setSerializationContext(SerializationContext::create()->setGroups(['StuffById'])->enableMaxDepthChecks());
		}else{
			$view = $this->view(array("message" => "No data"),404);
		}
		return $this->handleView($view);
	}
	
	/**
	 * Insert a helmet in the database.
	 * @Rest\Put("helmet")
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Put helmet in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Name of the stuff",
	 *   		"description" = "The name of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "rarity",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Rarity of the stuff",
	 *   		"description" = "The rarity of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "weight",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..1000",
	 *   		"description" = "The weight of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "perso",
	 *   		"dataType" = "Perso",
	 *   		"requirement" = "A valid perso",
	 *   		"description" = "The perso that holds the Helmet."
	 *   	}
	 *   },
	 * section="Helmet entity",
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	406 = "Not Acceptable"
	 *   }
	 * )
	 *
	 **/
	public function putHelmetAction(){
		$em = $this->getDoctrine()->getManager();
	
		$request = $this->getRequest()->request->all();
	
		$entity = new Helmet();
		$form = $this->createForm(new StuffType(),
					$entity, array('csrf_protection' => false));
		$request = $this->getRequest()->request->all();
		$form->submit($request);
		if($form->isValid()){
			$em->persist($entity);
			$em->flush();
			if($entity->getId()>0){
				$view = $this->view(array("helmet" => $entity),200);
			}else{
				$view = $this->view(array("message" => "No data"),406);
			}
		}else{
			$view = $this->view(array("message" => "Cannot insert data."),406);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['StuffById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}
	
	/**
	 * Update a helmet in the database.
	 * @Rest\Post("helmet/{id}")
	 * @param integer $id Id of the helmet instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Update helmet in database.",
	 *   requirements={
	 *   	{
	 *   		"name" = "name",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Name of the stuff",
	 *   		"description" = "The name of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "rarity",
	 *   		"dataType" = "string",
	 *   		"requirement" = "Rarity of the stuff",
	 *   		"description" = "The rarity of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "weight",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..1000",
	 *   		"description" = "The weight of the helmet."
	 *   	},
	 *   	{
	 *   		"name" = "perso",
	 *   		"dataType" = "Perso",
	 *   		"requirement" = "A valid perso",
	 *   		"description" = "The perso that holds the Helmet."
	 *   	}
	 *   },
	 * section="Helmet entity",
	 * statusCodes={
	 *   	200 = "Ok",
	 *   	418 = "I’m a teapot",
	 *   	422 = "Unprocessable entity"
	 *   }
	 * )
	 *
	 **/
	public function postHelmetAction($id){
		$em = $this->getDoctrine()->getManager();
	
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
			->findOneById($id);
		$beforeUpdate = $data->getUpdatedAt();
		if ($data){
			$form = $this->createForm(new StuffType(),
					$data, array('csrf_protection' => false));
			$request = $this->getRequest()->request->all();
			$form->submit($request);
			if($form->isValid()){
				$em->persist($data);
				$em->flush();
			}
			$dataAfterUpdate = $data = $em->getRepository('WebService\WebServiceBundle\Entity\Helmet')
				->findOneById($id);
			if($dataAfterUpdate->getUpdatedAt() != $beforeUpdate){
				$view = $this->view(array("helmet" => $dataAfterUpdate),200);
			}else{
				$view = $this->view(array("message" => "Update failed"),422);
			}
		}else{
			$view = $this->view(array("message" => "Entity not found"),418);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['StuffById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}
	
	/**
	 * Insert a register link in the database.
	 * @Rest\Put("register")
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Register a perso in a guild",
	 *   requirements={ 
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the guild."
	 *   	},
	 *   	{
	 *   		"name" = "rang",
	 *   		"dataType" = "string",
	 *   		"requirement" = "rank",
	 *   		"description" = "The rank of the guild."
	 *   	},
	 *   	{
	 *   		"name" = "guild",
	 *   		"dataType" = "Guild",
	 *   		"requirement" = "Valid guild",
	 *   		"description" = "The guild to register to."
	 *   	},
	 *   	{
	 *   		"name" = "perso",
	 *   		"dataType" = "Perso",
	 *   		"requirement" = "Valid perso",
	 *   		"description" = "The perso to register in the guild."
	 *   	}
	 *   },
	 *  section="Register entity",
	 *  statusCodes={
	 *   	200 = "Ok",
	 *   	406 = "Not Acceptable"
	 *   }
	 * )
	 **/ 
	public function putRegisterAction(){
		$em = $this->getDoctrine()->getManager();
		$entity = new Register();
		
		$form = $this->createForm(new RegisterType(), 
				$entity, array('csrf_protection' => false));
		
		$request = $this->getRequest()->request->all();
		
		$form->submit($request);
		if ($form->isValid()){
			$em->persist($entity);
			$em->flush();
		}
		if ($entity->getId() > 0){
			$view = $this->view(array("register" => $entity),200);
		}else{
			$view = $this->view(array("message" => "No data"),406);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['ById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}

	/**
	 * Update a register link in the database.
	 * @Rest\Post("register/{id}")
	 * @param integer $id Id of the register instance.
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ApiDoc(
	 *   description="Update a perso in a guild",
	 *   requirements={
	 *   	{
	 *   		"name" = "level",
	 *   		"dataType" = "integer",
	 *   		"requirement" = "0..100",
	 *   		"description" = "The level of the guild."
	 *   	},
	 *   	{
	 *   		"name" = "rang",
	 *   		"dataType" = "string",
	 *   		"requirement" = "rank",
	 *   		"description" = "The rank of the guild."
	 *   	},
	 *   	{
	 *   		"name" = "guild",
	 *   		"dataType" = "Guild",
	 *   		"requirement" = "Valid guild",
	 *   		"description" = "The guild to register to."
	 *   	},
	 *   	{
	 *   		"name" = "perso",
	 *   		"dataType" = "Perso",
	 *   		"requirement" = "Valid perso",
	 *   		"description" = "The perso to register in the guild."
	 *   	}
	 *   },
	 *  section="Register entity",
	 *  statusCodes={
	 *   	200 = "Ok",
	 *   	422 = "Unprocessable entity"
	 *   }
	 * )
	 **/
	public function postRegisterAction($id){
		$em = $this->getDoctrine()->getManager();
		$data = $em->getRepository('WebService\WebServiceBundle\Entity\Register')
			->findOneById($id);
		$beforeUpdate = $data->getUpdatedAt();
		$form = $this->createForm(new RegisterType(),
				$data, array('csrf_protection' => false));
		
		$request = $this->getRequest()->request->all();
		
		$form->submit($request);
		if ($form->isValid()){
			$em->persist($data);
			$em->flush();
			$dataAfterUpdate = $data = $em->getRepository('WebService\WebServiceBundle\Entity\Register')
				->findOneById($id);
			if($dataAfterUpdate->getUpdatedAt() != $beforeUpdate){
				$view = $this->view(array("register" => $dataAfterUpdate),200);
			}else{
				$view = $this->view(array("message" => "Update failed"),422);
			}
		}
		else{
			$view = $this->view(array("message" => "Entity not found"),422);
		}
		$view->setSerializationContext(SerializationContext::create()->setGroups(['ById'])->enableMaxDepthChecks());
		return $this->handleView($view);
	}
}
