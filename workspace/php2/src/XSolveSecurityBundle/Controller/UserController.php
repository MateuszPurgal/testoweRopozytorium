<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use XSolveSecurityBundle\Entity\User;


class UserController extends Controller {

   public function RestLoginAction(Request $request) {
      //get login and password from POST
      $username = $request->request->get('login');
      $password = $request->request->get('haslo');

      //autorizate token ( in class xsolve_autorization_manager )
      $autorizationManager = $this->get('x_solve_security.xsolve_autorization_manager');
      $authenticatedToken = $autorizationManager->getToken($username, $password);

      if (!$authenticatedToken) {

	 throw new AccessDeniedException('unable to find token');
      }
      $this->getUser()->assignNewToken();
      $this->getDoctrine()->getManager()->flush();

      return (new JsonResponse())->setData(
		      ['token' => $this->getUser()->getToken()->getToken()]);
   }
   public function ShowUserAction($id) {

      $user = $this->getDoctrine()
	      ->getRepository('XSolveSecurityBundle:User')
	      ->find($id);

      if (!$user) {

	 throw $this->createNotFoundException(
		 'No found user');
      }

      return (new JsonResponse())->setData(
		      ['login' => $user->getUsername(),
			'password' => $user->getPassword()]);
   }
   public function ShowAllUsersAction() {

      $users = $this->getDoctrine()
	      ->getRepository('XSolveSecurityBundle:User')
	      ->findAll();

      $tab = []; //tab contain id, usernames and passwords of all user in database
      for ($x = 0; $x < count($users); $x++) {
	 $element = [
	     'id' => $users[$x]->getId(),
	     'username' => $users[$x]->getUsername(),
	 ];
	 array_push($tab, $element);
      }

      $response = new jsonResponse();
      $response->setData($tab);

      return $response;
   }

   public function registerAction(Request $request) {
      
      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $user = new User();
      $user->setUsername($username);
      $user->setPassword($password);

      $em = $this->getDoctrine()->getManager(); //add user
      $em->persist($user);	  //to database
      $em->flush();

      return (new JsonResponse())->setData(
		      ['login' => $user->getUsername(),
			'password' => $user->getPassword(),
			'ID' => $user->getID()]);
   }

}
