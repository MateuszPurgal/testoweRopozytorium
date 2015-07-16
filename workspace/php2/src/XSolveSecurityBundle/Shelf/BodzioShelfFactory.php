<?php
namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\InsertionAlghoritms\InsertionIntoSortedResources;
use XSolveSecurityBundle\Shelf\AbstractShelfFactory;

class BodzioShelfFactory implements AbstractShelfFactory {

   public function create() {
      return new Shelf(6, new InsertionIntoSortedResources());
   }

}
