<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use XSolveSecurityBundle\Entity\User;

class UserController extends Controller {

   public function RestLoginAction(Request $request) {

      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $autorizationManager = $this->get('x_solve_security.xsolve_autorization_manager');
      $authenticatedToken = $autorizationManager->getToken($username, $password);
      if (!$authenticatedToken) {

	 throw new NotFoundException('unable to find token');
      }
      $this->getUser()->assignNewToken();
      $this->getDoctrine()->getManager()->flush();
      $jsonResponse = new JsonResponse();
      $jsonResponse->setData(['token' => $this->getUser()->getToken()->getToken()]);

      return $jsonResponse;
   }

   public function ShowUserAction($id) {

      $user = $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->find($id);
      if (!$user) {
	 throw $this->NotFoundException('No found user');
      }
      $jsonResponse = new JsonResponse();
      $jsonResponse->setData(['login' => $user->getUsername(), 'password' => $user->getPassword()]);

      return $jsonResponse;
   }

   public function ShowAllUsersAction() {

      $users = $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->getAllUsersJson();

      return $users;
   }

   public function registerAction(Request $request) {

      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $user = new User($username, $password);
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      $jsonResponse = new JsonResponse();
      $jsonResponse->setData(['login' => $user->getUsername(), 'password' => $user->getPassword(), 'ID' => $user->getID()]);

      return $jsonResponse;
   }

}
