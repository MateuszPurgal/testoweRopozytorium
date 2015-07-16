<?php

namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\InsertionAlghoritms\InsertionAlgorithmsInterface;
use XSolveSecurityBundle\Entity\Resource;

class RestrictiveShelf extends Shelf {

   public function __construct($capacity, InsertionAlgorithmsInterface $insertionAlgorithm) {
      parent::__construct($capacity, $insertionAlgorithm);
   }

   public function isOccupied($index) {
      if ($index >= $this->capacity || $index < 0) {
	 throw new \OutOfRangeException("Out of range if restrictive shelf");
      }
      return isset($this->tab[$index]);
   }

   public function isFree($index) {
      return !$this->isOccupied($index);
   }

   public function getClassofElement($index) {
      if ($index >= $this->capacity || $index < 0) {
	 throw new \OutOfRangeException("Out of range if restrictive shelf");
      }
      return get_class($this->tab[$index]);
   }

}
