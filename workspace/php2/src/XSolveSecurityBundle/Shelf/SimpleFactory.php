<?php

namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\Shelf\RestrictiveShelf;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtLastFreePosition;
use XSolveSecurityBundle\InsertionAlghoritms\InsertionIntoSortedResources;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtFirstFreePosition;

/**
 * class ConcreteFactory
 */
class SimpleFactory {



   public function __construct() {

   }

   /**
    * Creates a vehicle
    *
    * @param string $type a known type key
    *
    * @throws \InvalidArgumentException
    */
   public function createShelf($type) {

      switch ($type) {

	 case 'AgataShelf':
	    return new Shelf(8, new InsertAtFirstFreePosition());
	 case 'BlackRedWhiteShelf':
	    return new RestrictiveShelf(15, new InsertAtLastFreePosition());
	 case 'BodzioShelf':
	    return new Shelf(6, new InsertionIntoSortedResources());
	 case 'IkeaShelf':
	    return new Shelf(6, new InsertAtFirstFreePosition());
	 default :
	    throw new \InvalidArgumentException("$type is not valid shelf");
      }

   }

}
