<?php

namespace XSolveSecurityBundle\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use XSolveSecurityBundle\Entity\User;

class PasswordChanger {

   protected $encoder;

   public function __construct(UserPasswordEncoderInterface $encoder) {

      $this->encoder = $encoder;
   }
   public function updateUserPassword(User $user, $password) {

      $newPassword = $this->encoder->encodePassword($user, $password);
      $user->setPassword($newPassword);

      return $newPassword;
   }

}
