<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller {

   public function RestLoginAction(Request $request) {
      //get login and password from POST
      $username = $request->request->get('login');
      $password = $request->request->get('haslo');

      //autorizate token ( in class xsolve_autorization_manager )
      $autorizationManager = $this->get('x_solve_security.xsolve_autorization_manager');
      $authenticatedToken = $autorizationManager->getToken($username, $password);

      if ($authenticatedToken) {
	 $this->getUser()->assignNewToken();
	 $this->getDoctrine()->getManager()->flush();


	 return (new JsonResponse())->setData(
			 ['login' => $username,
			  'password' => $username,
		          'token' => $this->getUser()->getToken()->getToken()]);
      }
      throw new AccessDeniedException('unable to find token');
   }

}
