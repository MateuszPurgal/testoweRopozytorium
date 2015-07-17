<?php

namespace XSolveSecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use XSolveSecurityBundle\Entity\User;
use XSolveSecurityBundle\Models\UserModel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use XSolveSecurityBundle\Entity\Resource;
use \XSolveSecurityBundle\Models\ResourceModel;
use XSolveSecurityBundle\Models\Shelf;
use XSolveSecurityBundle\Entity\Video;
use XSolveSecurityBundle\Entity\Image;

class UserController extends Controller {

   public function getUsersAction() {
      $users = $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->findAll();

      $tab = []; 
      foreach ($users as $user) {
	 $usermodel = new UserModel($user);
	 $element = [$usermodel->getViewData()];
	 $tab[] = $element;
      }
      $response = new JsonResponse();
      $response->setData($tab);

      return $response;
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

   public function postUserAction(Request $request) {

      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $passwordChanger = $this->container->get('x_solve_security.xsolve_password_changer');
      $user = new User($username);
      $passwordChanger->updateUserPassword($user, $password);
      $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->saveUser($user);

      $jsonResponse = new JsonResponse();
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());
      $jsonResponse->setStatusCode(201);

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
      $passwordChanger = $this->container->get('x_solve_security.xsolve_password_changer');
      $username = $request->request->get('login');
      $password = $request->request->get('haslo');
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('XSolveSecurityBundle:User')->find($id);
      if (!$user) {

	 throw $this->createNotFoundException('No guest found for id ' . $id);
      }
      $user->setUsername($username);
      $passwordChanger->updateUserPassword($user, $password);
      $em->flush();
      $jsonResponse = new JsonResponse();
      $userModel = new UserModel($user);
      $jsonResponse->setData($userModel->getViewData());
      $jsonResponse->setStatusCode(200);

      return $jsonResponse;
   }

   public function restLoginAction(Request $request) {
//TODO///////////////////////////////////////////////////////////////////////
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
      $userModel = new UserModel($this->getUser());
      $tokenValue = $userModel->getTokenValue();
      $jsonResponse->setData($tokenValue);

///////////////////////TEST/////////////////////////////////////////////////////////
      $cookie = new Cookie('X-Token', $this->getUser()->getToken()->getToken());
      $jsonResponse->headers->setCookie($cookie);

      //$jsonResponse->headers->addCacheControlDirective();
      // dump($jsonResponse->headers);
      // die();
      //$jsonResponse->headers->setCookie($cookie);

      return $jsonResponse;
   }

   public function testAction() {
      $user = $this->getDoctrine()->getRepository('XSolveSecurityBundle:User')->find(19);
      if (!$user) {

	 throw new NotFoundHttpException("Unable to find user");
      }
      $zasob = new Resource();
      $zasob->setUser($user);
      // $zasob->setImageUrl('URL image');
      $em = $this->getDoctrine()->getManager();
      $em->persist($zasob);
      $em->flush();

      return new JsonResponse();
   }

   public function getResourcesAction() {
      $data = $this->getDoctrine()->getRepository('XSolveSecurityBundle:Resource')->findAll();
      $tab = []; //tab contain id, usernames and passwords of all user in database
      foreach ($data as $user) {
         $resourceModel = new ResourceModel($user);
	 $tab[] =  $resourceModel->getViewData();
      }
      $response = new JsonResponse();
      $response->setData($tab);

      return $response;
   }

   public function getVideosAction() {
      $query = $this->getDoctrine()->getRepository('XSolveSecurityBundle:Video')->findAll();
      $tab = []; //tab contain id, usernames and passwords of all user in database
      foreach ($query as $video) {
	 $tab[] = ['id' => $video->getId(), 'video URL' => $video->getVideoUrl()];
      }
      $response = new JsonResponse();
      $response->setData($tab);

      return $response;
   }

   public function getImagesAction() {
      $query = $this->getDoctrine()->getRepository('XSolveSecurityBundle:Image')->findAll();
      $tab = []; //tab contain id, usernames and passwords of all user in database
      foreach ($query as $image) {
	 $tab[] = ['id' => $image->getId(), 'iamge URL' => $image->getImageUrl()];
      }
      $response = new JsonResponse();
      $response->setData($tab);

      return $response;
   }

}
