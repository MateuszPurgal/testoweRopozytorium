<?php
namespace XSolveSecurityBundle\Security;

use XSolveSecurityBundle\Entity\User;

class UserModel {
   protected $user;

   public function __construct(User $user) {
      $this->user = $user;
   }

   public function getViewData() {

      return ['login' => $this->user->getUsername(), 'password' => $this->user->getPassword(), 'ID' => $this->user->getID()];
   }

}
