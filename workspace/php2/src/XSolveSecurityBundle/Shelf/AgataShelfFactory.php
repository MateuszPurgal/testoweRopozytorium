<?php

namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtFirstFreePosition;
use XSolveSecurityBundle\Shelf\AbstractShelfFactory;

class AgataShelfFactory implements AbstractShelfFactory {

   function create() {
      return new Shelf(8, new InsertAtFirstFreePosition());
   }

}

