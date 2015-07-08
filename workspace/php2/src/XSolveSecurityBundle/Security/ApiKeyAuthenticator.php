<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
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
	 sprintf(
		 'The user provider must be an instance of ApiKeyUserProvider (%s was given).'
		 , get_class($userProvider)));
      }

      $apiKey = $token->getCredentials();

      $username = $userProvider->getUsernameForApiKey($apiKey);
      
      // User is the Entity which represents your user
      $user = $token->getUser();
      if ($user instanceof User) {
	 return new PreAuthenticatedToken(
		 $user, $apiKey, $providerKey, $user->getRoles()
	 );
      }

      if (!$username) {
	 throw new AuthenticationException(
	 sprintf('API Key "%s" does not exist.', $apiKey)
	 );
      }

      $user = $userProvider->loadUserByUsername($username);
      return new PreAuthenticatedToken(	      $user, $apiKey, $providerKey, $user->getRoles());
   }
   public function supportsToken(TokenInterface $token, $providerKey) {
      return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
   }

}