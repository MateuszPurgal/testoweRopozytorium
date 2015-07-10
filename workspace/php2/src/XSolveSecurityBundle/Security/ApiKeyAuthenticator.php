<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface {

   public function createToken(Request $request, $providerKey) {
     
      $apiKey = $request->query->get('apikey');

      if (!$apiKey) {
	 throw new BadCredentialsException('No API key found');
      }

      return new PreAuthenticatedToken(
	      'anon.', $apiKey, $providerKey
      );
   }

   public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {

      if (!$userProvider instanceof XsolveAuthenticationProviderManager) {
	 throw new \InvalidArgumentException(
	 sprintf('The user provider must be an instance of ApiKeyUserProvider (%s was given).'
		 , get_class($userProvider)));
      }

      $apiKey = $token->getCredentials();
      $username = $userProvider->getUsernameForApiKey($apiKey);
      $userToken = $token->getUser();

      if ($userToken instanceof User) {

	 return new PreAuthenticatedToken(
		 $userToken, $apiKey, $providerKey, $userToken->getRoles());
      }

      $userUsername = $userProvider->loadUserByUsername($username);

      return new PreAuthenticatedToken($userUsername, $apiKey, $providerKey, $userUsername->getRoles());
   }

   public function supportsToken(TokenInterface $token, $providerKey) {

      return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
   }

}
