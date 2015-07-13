<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use XSolveSecurityBundle\Entity\User;
use XSolveSecurityBundle\Security\UserModel;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller {

   public function getUsersAction() {

      $users = $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->getAllUsersJson();

      return $users;
   }

   public function postUserAction(Request $request) {

      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $user = new User($username, $password);
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      $jsonResponse = new JsonResponse();
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());
      $jsonResponse->setStatusCode(201);

      return $jsonResponse;
   }

   public function getUserAction($id) {

      $user = $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->find($id);
      if (!$user) {

	 throw new NotFoundHttpException("Unable to find user");
      }
      $jsonResponse = new JsonResponse();
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());

      return $jsonResponse;
   }

   public function deleteUserAction($id) {

      $em = $this->getDoctrine()->getEntityManager();
      $user = $em->getRepository('XSolveSecurityBundle:User')->find($id);
      if (!$user) {

	 throw $this->createNotFoundException('No guest found for id ' . $id);
      }
      $em->remove($user);
      $em->flush();

      return new Response('', 204);
   }

   public function putUserAction(Request $request, $id) {

      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('XSolveSecurityBundle:User')->find($id);
      if (!$user) {

	 throw $this->createNotFoundException('No guest found for id ' . $id);
      }
      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $user->setUsername($username);
      $user->setPassword($password);
      $em->flush();
      $jsonResponse = new JsonResponse();
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());
      $jsonResponse->setStatusCode(200);

      return $jsonResponse;
   }

   public function restLoginAction(Request $request) {

      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $autorizationManager = $this->get('x_solve_security.xsolve_autorization_manager');
      $authenticatedToken = $autorizationManager->getToken($username, $password);
      if (!$authenticatedToken) {

	 throw new NotFoundHttpException('Unable to find token');
      }
      $this->getUser()->assignNewToken();
      $this->getDoctrine()->getManager()->flush();
      $jsonResponse = new JsonResponse();
      $jsonResponse->setData(['token' => $this->getUser()->getToken()->getToken()]);

      return $jsonResponse;
   }

}
