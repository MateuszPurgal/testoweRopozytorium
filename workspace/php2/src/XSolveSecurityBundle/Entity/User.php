<?php

namespace XSolveSecurityBundle\Entity;

use XSolveSecurityBundle\Entity\Tokens;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="XSolveSecurityBundle\Entity\UserRepository")
 */
class User implements UserInterface {

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
    * @ORM\Column(name="username", type="string", length=255, unique=true)
    */
   private $username;

   /**
    * @var string
    *
    * @ORM\Column(name="password", type="string", length=255)
    */
   private $password;

   /**
    * @ORM\OneToOne(targetEntity="Tokens", mappedBy="user" ,cascade={"persist"})
    * */
   protected $token;

   public function __construct($username = null, $password = null) {
      $this->username = $username;
      $this->password = $password;
   }

   /**
    * Get id
    *
    * @return integer
    */
   public function getId() {
      return $this->id;
   }

   /**
    * Set username
    *
    * @param string $username
    * @return User
    */
   public function setUsername($username) {
      $this->username = $username;

      return $this;
   }

   /**
    * Get username
    *
    * @return string 
    */
   public function getUsername() {
      return $this->username;
   }

   /**
    * Set password
    *
    * @param string $password
    * @return User
    */
   public function setPassword($password) {
      $this->password = $password;

      return $this;
   }

   /**
    * Get password
    *
    * @return string
    */
   public function getPassword() {

      return $this->password;
   }

   public function getSalt() {

      return null;
   }

   public function getRoles() {
      if ($this->username == 'admin') {

	 return array('ROLE_ADMIN');
      }

      return array('ROLE_USER');
   }

   public function eraseCredentials() {
      
   }

   /** @see \Serializable::serialize() */
   public function serialize() {

      return serialize([$this->id, $this->username, $this->password]);
   }

   /** @see \Serializable::unserialize() */
   public function unserialize($serialized) {

      list ($this->id, $this->username, $this->password) = unserialize($serialized);
   }

   public function assignNewToken() {
      $token = $this->getToken();
      if ($token == null) {
	 $token = new Tokens();
      }

      $token->generate();
      $token->setUser($this);
      $this->setToken($token);

      return $this;
   }

   /**
    * Set token
    *
    * @param integer $token
    * @return User
    */
   public function setToken(Tokens $token) {
      $this->token = $token;
      return $this;
   }

   /**
    * Get token
    *
    * @return integer
    */
   public function getToken() {
      return $this->token;
   }

}
