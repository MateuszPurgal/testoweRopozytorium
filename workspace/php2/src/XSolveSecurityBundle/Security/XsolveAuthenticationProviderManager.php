<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class XsolveAuthenticationProviderManager implements UserProviderInterface {

   protected $entityManager;
   
   public function __construct(\Doctrine\ORM\EntityManager $entityManger) {
      $this->entityManager = $entityManger;
   }

   public function getUsernameForApiKey($apiKey) {
      $token = $this->entityManager->getRepository('XSolveSecurityBundle:Tokens')
	      ->findOneBy(['token' => $apiKey]);
      if (!$token) {
	 throw new NotFoundHttpException("Unable to find token");
      }

      return $token->getUser()->getUsername();
   }

   public function loadUserByUsername($username) {
      $user = $this->entityManager->getRepository('XSolveSecurityBundle:User')->
	      findOneBy(['username' => $username]);
      if (!$user) {
	 throw new NotFoundHttpException("Unable to find user");
      }

      return $user;
   }
    public function refreshUser(UserInterface $user) {
      $class = get_class($user);
      if (!$this->supportsClass($class)) {
	 throw new UnsupportedUserException(
	 sprintf(
		 'Instances of "%s" are not supported.', $class
	 )
	 );
      }

      return $this->find($user->getId());
   }


    public function supportsClass($class) {
      return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
   }

}
