<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller {

   public function indexAction() {

      return $this->render('XSolveSecurityBundle:Default:index.html.twig');
   }

}
