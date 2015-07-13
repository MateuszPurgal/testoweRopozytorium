<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use XSolveSecurityBundle\Entity\User;

class XsolveAuthenticationProviderManager implements UserProviderInterface {

   protected $entityManager;
   
   public function __construct(\Doctrine\ORM\EntityManager $entityManger) {
      $this->entityManager = $entityManger;
   }

   public function getUsernameForApiKey($apiKey) {

      $token = $this->entityManager->getRepository('XSolveSecurityBundle:Tokens')->findOneBy(['token' => $apiKey]);
      if (!$token) {

	 throw new NotFoundHttpException("Unable to find token");
      }

      return $token->getUser()->getUsername();
   }

   public function loadUserByUsername($username) {

      $user = $this->entityManager->getRepository('XSolveSecurityBundle:User')->findOneBy(['username' => $username]);
      if (!$user) {

	 throw new NotFoundHttpException("Unable to find user");
      }

      return $user;
   }

   public function refreshUser(UserInterface $user) {
     
      if (!$user instanceof User) {

	 throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
      }

      return $this->loadUserByUsername($user->getUsername());
   }

   public function supportsClass($class) {

      return 'Symfony\Component\Security\Core\User\User' === $class;
   }

}
