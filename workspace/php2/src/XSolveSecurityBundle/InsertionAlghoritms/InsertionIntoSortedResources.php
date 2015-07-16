<?php

namespace XSolveSecurityBundle\InsertionAlghoritms;

use XSolveSecurityBundle\InsertionAlghoritms\InsertionAlgorithmsInterface;
use XSolveSecurityBundle\Entity\Resource;
use XSolveSecurityBundle\Models\Shelf;

class InsertionIntoSortedResources implements InsertionAlgorithmsInterface {

   public function tableWitchNewElement(Shelf $shelf, Resource $resource) {
      $tab = $shelf->getAllElements();
      if ($shelf->getSize() == 0 || get_class($resource) != get_class($tab[0])) {
	 for ($i = 0; $i < $shelf->getCapacity(); $i++) {
	    if ($shelf->isFree($i)) {
	       $tab[$i] = $resource;
	       break;
	    }
	 }

	 return $tab;
      }

      $j = 1;
      while (isset($tab[$j]) && (get_class($tab[$j]) == get_class($resource))) {
	 $j++;
      }

      for ($i = ($shelf->getCapacity() - 1); $i > $j; $i--) {
	 if (isset($tab[$i - 1])) {
	    $tab[$i] = $tab[$i - 1];
	 }
      }
      $tab[$j] = $resource;

      return $tab;
   }

}
