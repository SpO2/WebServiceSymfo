<?php

namespace WebService\WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WebServiceWebServiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
