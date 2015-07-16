<?php

namespace XSolveSecurityBundle\Models;

use XSolveSecurityBundle\Entity\User;

class UserModel {

   protected $user;

   public function __construct(User $user) {
      $this->user = $user;
   }

   public function getViewData() {
      return ['login' => $this->user->getUsername(),'id' => $this->user->getId()];
   }

   public function getTokenValue() {
      return ['token' => $this->user->getToken()->getToken()];
   }


}
                 