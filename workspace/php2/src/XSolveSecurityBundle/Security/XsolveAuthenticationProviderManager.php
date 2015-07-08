<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class XsolveAuthenticationProviderManager implements UserProviderInterface {

   protected $entityManager;

   public function __construct(\Doctrine\ORM\EntityManager $entityManger) {
      $this->entityManager = $entityManger;
   }
   public function getUsernameForApiKey($apiKey) {

      $token = $this->entityManager->getRepository('XSolveSecurityBundle:Tokens')->findOneBy(['token' => $apiKey]);
      if (!$token) {
	 throw new AccessDeniedException('unable to find token');
      }
      return $token->getUser()->getUsername();
   }
   public function loadUserByUsername($username) {

      $user = $this->entityManager->getRepository('XSolveSecurityBundle:User')->findOneBy(['username' => $username]);
      if (!$user) {
	 throw new AccessDeniedException('unable to find user');
      }
      return $user;
   }
   public function refreshUser(UserInterface $user) {
     
      if (!$user instanceof WebserviceUser) {
	 throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
      }
      return $this->loadUserByUsername($user->getUsername());
   }
   public function supportsClass($class) {
      return 'Symfony\Component\Security\Core\User\User' === $class;
   }

}
