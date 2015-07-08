<?php

namespace XSolveSecurityBundle\Controller;

use XSolveSecurityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {

   public function indexAction() {

      return $this->render('XSolveSecurityBundle:Default:index.html.twig');
   }



 

}
