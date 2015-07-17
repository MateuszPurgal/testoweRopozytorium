<?php

namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtFirstFreePosition;
use XSolveSecurityBundle\Shelf\AbstractShelfFactory;

class IkeaShelfFactory implements AbstractShelfFactory {

   function create() {
      return new Shelf(6, new InsertAtFirstFreePosition());
   }

}
