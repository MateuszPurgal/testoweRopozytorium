<?php

namespace XSolveSecurityBundle\Models;

use XSolveSecurityBundle\Models\VideoModel;
use XSolveSecurityBundle\Models\ImageModel;
use XSolveSecurityBundle\Entity\Resource;


class ResourceModel {

   protected $resource;

   public function __construct(Resource $resource) {

      $this->resource = $resource;
   }

   public function getViewData() {

      $tab = ['id' => $this->resource->getId(),
	  'user_id' => $this->resource->getUser()->getId()];
      if (get_class($this->resource) == 'XSolveSecurityBundle\Entity\Video') {
	 $videoModel = new VideoModel($this->resource);
	 $tab = array_merge($tab, $videoModel->getAdditionalData());
      }
      if (get_class($this->resource) == 'XSolveSecurityBundle\Entity\Image') {
	 $imageModel = new ImageModel($this->resource);
	 $tab = array_merge($tab, $imageModel->getAdditionalData());
      }

      return $tab;
   }

}
