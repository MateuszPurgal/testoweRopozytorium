<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AuthorizationManager {

   protected $userProvider;
   protected $providerKey;
   protected $tokenStorage;
   protected $encoderFactory;

   public function __construct(XsolveAuthenticationProviderManager $userProvider, $providerKey, TokenStorage $tokenStorage, EncoderFactory $encoderFactory) {
      $this->userProvider = $userProvider;
      $this->providerKey = $providerKey;
      $this->tokenStorage = $tokenStorage;
      $this->encoderFactory = $encoderFactory;
   }

   
   public function getToken($username, $password) {
      $provider = $this->getAuthProvider($this->encoderFactory);
      $unauthenticatedToken = new UsernamePasswordToken($username, $password, $this->providerKey);
      $authenticationManager = new AuthenticationProviderManager([$provider]);
      try {
	 $authenticatedToken = $authenticationManager->authenticate($unauthenticatedToken);
      } catch (AuthenticationException $failed) {

	 return null;
      }
      $this->saveToken($authenticatedToken);

      return $authenticatedToken;
   }

   public function saveToken($authenticatedToken) {
      if (!$authenticatedToken) {

	 return null;
      }

      return $this->tokenStorage->setToken($authenticatedToken);
   }

   protected function getAuthProvider(EncoderFactory $encoderFactory) {

      return new DaoAuthenticationProvider(
	      $this->userProvider, new UserChecker(), $this->providerKey, $encoderFactory
      );
   }

}
