<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use XSolveSecurityBundle\Entity\User;
use XSolveSecurityBundle\Security\UserModel;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
	 	 throw new NotFoundHttpException("Unable to find user");
      }
      $jsonResponse = new JsonResponse();
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());
  
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
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());

      return $jsonResponse;
   }

}
