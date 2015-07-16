<?php

namespace XSolveSecurityBundle\InsertionAlghoritms;

use XSolveSecurityBundle\Entity\Resource;
use XSolveSecurityBundle\Shelf\Shelf;

class InsertAtLastFreePosition implements InsertionAlgorithmsInterface {

   public function tableWitchNewElement(Shelf $shelf, Resource $resource) {
      $tab = $shelf->getAllElements();
      for ($i = ($shelf->getCapacity() - 1); $i >= 0; $i--) {
	 if ($shelf->isFree($i)) {
	    $tab[$i] = $resource;
	    break;
	 }
      }

      return $tab;
   }


}
