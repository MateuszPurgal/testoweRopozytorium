<?php
namespace XSolveSecurityBundle\Models;

use XSolveSecurityBundle\Entity\Image;

class ImageModel {

   protected $image;

   public function __construct(Image $image) {

      $this->image = $image;
   }

   public function getAdditionalData() {

      return ['image URL' => $this->image->getImageUrl()];
   }

}
