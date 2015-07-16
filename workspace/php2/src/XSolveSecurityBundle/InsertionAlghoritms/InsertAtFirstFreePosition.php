<?php

namespace XSolveSecurityBundle\InsertionAlghoritms;

use XSolveSecurityBundle\InsertionAlghoritms\InsertionAlgorithmsInterface;
use XSolveSecurityBundle\Entity\Resource;
use XSolveSecurityBundle\Shelf\Shelf;

class InsertAtFirstFreePosition implements InsertionAlgorithmsInterface {

   public function tableWitchNewElement(Shelf $shelf, Resource $resource) {
      $tab = $shelf->getAllElements();
      for ($i = 0; $i < $shelf->getCapacity(); $i++) {
	 if ($shelf->isFree($i)) {
	    $tab[$i] = $resource;
	    break;
	 }
      }

      return $tab;
   }


}
