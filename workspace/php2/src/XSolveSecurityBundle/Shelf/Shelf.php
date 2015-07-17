<?php

namespace XSolveSecurityBundle\Shelf;

use XSolveSecurityBundle\InsertionAlghoritms\InsertionAlgorithmsInterface;
use XSolveSecurityBundle\Entity\Resource;

class Shelf {

   protected $tab;
   protected $size;
   protected $capacity;
   protected $insertionAlgorithm;

   public function __construct($capacity, InsertionAlgorithmsInterface $insertionAlgorithm) {
      $this->insertionAlgorithm = $insertionAlgorithm;
      $this->tab = [];
      $this->capacity = $capacity;
      if ($capacity < 0) {
	 throw new \InvalidArgumentException('Capacity of shelf is negative');
      }
      $this->size = 0;
   }

   public function getSize() {
      return $this->size;
   }

   public function getCapacity() {
      return $this->capacity;
   }

   public function isOccupied($index) {
      return !$this->isFree($index);
   }

   public function isFree($index) {
      return !isset($this->tab[$index]);
   }

   public function getClassofElement($index) {
      return get_class($this->tab[$index]);
   }

   public function getElement($index) {
      if ($this->isFree($index)) {
	 return null;
      }

      return $this->tab[$index];
   }

   public function getAllElements() {
      return $this->tab;
   }

   public function putElementOnShelf(Resource $resource) {
      if ($this->size === $this->capacity) {
	 throw new \OutOfRangeException('Out of range shelf');
      }

      $this->tab = $this->insertionAlgorithm->tableWitchNewElement($this, $resource);
      $this->size++;

      return $this;
   }


}
