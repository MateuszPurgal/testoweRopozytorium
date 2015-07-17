<?php

namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtLastFreePosition;
use XSolveSecurityBundle\Shelf\AbstractShelfFactory;

class BlackRedWhiteShelfFactory implements AbstractShelfFactory {

   function create() {
      return new RestrictiveShelf(15, new InsertAtLastFreePosition());
   }

}
