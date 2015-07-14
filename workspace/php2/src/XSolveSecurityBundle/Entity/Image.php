<?php

namespace XSolveSecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use XSolveSecurityBundle\Entity\Resource;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="XSolveSecurityBundle\Entity\ImageRepository")
 */
class Image extends Resource {

   /**
    * @var integer
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

   /**
    * @var string
    *
    * @ORM\Column(name="image_url", type="text")
    */
   protected $image_url;

   /**
    * Get id
    *
    * @return integer
    */
   public function getId() {
      return $this->id;
   }

   /**
    * Set image_url
    *
    * @param string $imageUrl
    * @return Image
    */
   public function setImageUrl($imageUrl) {
      $this->image_url = $imageUrl;

      return $this;
   }

   /**
    * Get image_url
    *
    * @return string
    */
   public function getImageUrl() {
      return $this->image_url;
   }



}
