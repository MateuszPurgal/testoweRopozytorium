<?php

namespace XSolveSecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use XSolveSecurityBundle\Entity\User;

/**
 * Tokens
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="XSolveSecurityBundle\Entity\TokensRepository")
 */
class Tokens {

   /**
    * @var integer
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   private $id;

   /**
    * @var string
    *
    * @ORM\Column(name="Token", type="text")
    */
   private $token;

   /**

    * @ORM\OneToOne(targetEntity="User", inversedBy="token", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id" , nullable=false)
    * 
    * */
   private $user;

   /**
    * Get id
    *
    * @return integer
    */
   public function getId() {
      return $this->id;
   }

   /**
    * Set Token
    *
    * @param string $token
    * @return Tokens
    */
   public function setToken($token) {
      if ($token == null) {
	 $this->token = generate();
      } else {
	 $this->token = $token;
      }

      return $this;
   }

   /**
    * Get Token
    *
    * @return string
    */
   public function getToken() {
      return $this->token;
   }

   /**
    * Set user
    *
    * @param User $user
    * @return Tokens
    */
   public function setUser(User $user) {
      $this->user = $user;

      return $this;
   }

   /**
    * Get user
    *
    * @return integer
    */
   public function getUser() {
      return $this->user;
   }

   public function generate() {
      $this->token = (string) rand(1000, 9999);

      return $this;
   }

}
