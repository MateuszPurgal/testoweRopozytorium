<?php

namespace XSolveSecurityBundle\Models;

use XSolveSecurityBundle\Entity\Video;


class VideoModel {

   protected $video;

   public function __construct(Video $video) {

      $this->video = $video;
   }

   public function getAdditionalData() {

      return ['video URL' => $this->video->getVideoUrl()];
   }

}
