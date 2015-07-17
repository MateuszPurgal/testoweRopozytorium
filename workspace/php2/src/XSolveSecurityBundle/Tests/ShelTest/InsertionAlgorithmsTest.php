<?php

namespace XSolveSecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use XSolveSecurityBundle\Entity\Video;
use XSolveSecurityBundle\Entity\Image;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtFirstFreePosition;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtLastFreePosition;
use XSolveSecurityBundle\InsertionAlghoritms\InsertionIntoSortedResources;
use XSolveSecurityBundle\Shelf\RestrictiveShelf;
use XSolveSecurityBundle\Shelf\Shelf;
use XSolveSecurityBundle\Shelf\SimpleFactory;

class DefaultControllerTest extends WebTestCase {



   public function putDataIntoShelf(Shelf $shelf, $data) {

      for ($i = 0; $i < count($data); $i++) {
	 $shelf->putElementOnShelf($data[$i]);
      }
      return $shelf;
   }

   /**
    * @dataProvider provideAllAlgorithmsAndData
    */
   public function testInsertAlgorithms($algorithm, $data) {
      $shelf = new RestrictiveShelf(6, $algorithm);
      $this->putDataIntoShelf($shelf, $this->provideData());

      $this->assertEquals($data, $shelf->getAllElements());
   }

 
  /**
    * @dataProvider provideAllAlgorithmsAndHalfData
    */
   public function testInsertAlgorithmsEmptySpaces($algorithm, $data) {

      $shelf = new RestrictiveShelf(6, $algorithm);
      $this->putDataIntoShelf($shelf, $this->provideHalfData());

      $this->assertEquals($data, $shelf->getAllElements());
   }

   /**
    * @dataProvider provideAllAlgorithms
    */
   public function testShelfSize($algorithm) {


      $shelfFactory = new SimpleFactory();
      $shelf = $shelfFactory->createShelf('IkeaShelf', $algorithm);

      $data = [new Image(), new Video()];
      $this->putDataIntoShelf($shelf, $data);

      $this->assertEquals(2, $shelf->getSize());
   }

   /**
    * @expectedException OutOfRangeException
    * @expectedExceptionMessage Out of range shelf
    */
   public function testShelfOverSize() {
      $shelf = new RestrictiveShelf(1, new InsertAtFirstFreePosition());
      $data = [new Image(), new Video()];
      $this->putDataIntoShelf($shelf, $data);
   }

   /**
    * @expectedException InvalidArgumentException
    * @expectedExceptionMessage Capacity of shelf is negative
    */
   public function testShelfNegativeCapacity() {
      new Shelf(-6, new InsertAtFirstFreePosition());
   }

   /**
    * @expectedException OutOfRangeException
    * @expectedExceptionMessage Out of range if restrictive shelf
    */
   public function testRestrictiveShelfOutOfRangeIsOccupied() {
      $shelf = new RestrictiveShelf(3, new InsertAtFirstFreePosition());
      $shelf->isOccupied(50);
   }

   /**
    * @expectedException OutOfRangeException
    * @expectedExceptionMessage Out of range if restrictive shelf
    */
   public function testRestrictiveShelfGetClassofElement() {
      $shelf = new RestrictiveShelf(3, new InsertAtFirstFreePosition());
      $shelf->getClassofElement(50);
   }

   /**
    * @expectedException OutOfRangeException
    * @expectedExceptionMessage Out of range if restrictive shelf
    */
   public function testRestrictiveShelfOutOfRangeIsFree() {
      $shelf = new RestrictiveShelf(3, new InsertAtFirstFreePosition());
      $shelf->isFree(50);
   }
   public function provideData() {
      return [
	  (new Video())->setName('Film1'),
	  (new Image())->setName('Image1'),
	  (new Video())->setName('Film2'),
	  (new Image())->setName('Image2'),
	  (new Video())->setName('Film3'),
	  (new Video())->setName('Film4')
      ];
   }

   public function provideHalfData() {
      return [
	  (new Video())->setName('Film1'),
	  (new Image())->setName('Image1'),
	  (new Video())->setName('Film2')
      ];
   }

   public function provideAllAlgorithms() {
      return [
	  [new InsertAtFirstFreePosition()],
	  [new InsertAtLastFreePosition()],
	  [new InsertionIntoSortedResources()]
      ];
   }

   public function provideAllAlgorithmsAndData() {
      return [
	  [new InsertAtFirstFreePosition(), [
		  (new Video())->setName('Film1'),
		  (new Image())->setName('Image1'),
		  (new Video())->setName('Film2'),
		  (new Image())->setName('Image2'),
		  (new Video())->setName('Film3'),
		  (new Video())->setName('Film4')
	      ]],
	  [new InsertAtLastFreePosition(), [
		  (new Video())->setName('Film4'),
		  (new Video())->setName('Film3'),
		  (new Image())->setName('Image2'),
		  (new Video())->setName('Film2'),
		  (new Image())->setName('Image1'),
		  (new Video())->setName('Film1')
	      ]],
	  [new InsertionIntoSortedResources(), [
		  (new Video())->setName('Film1'),
		  (new Video())->setName('Film2'),
		  (new Video())->setName('Film3'),
		  (new Video())->setName('Film4'),
		  (new Image())->setName('Image1'),
		  (new Image())->setName('Image2')
	      ]]
      ];
   }

   public function provideAllAlgorithmsAndHalfData() {
      $tab[3] = (new Video())->setName('Film2');
      $tab[4] = (new Image())->setName('Image1');
      $tab[5] = (new Video())->setName('Film1');
      return [
	  [new InsertAtFirstFreePosition(), [
		  (new Video())->setName('Film1'),
		  (new Image())->setName('Image1'),
		  (new Video())->setName('Film2')
	      ]],
	  [new InsertAtLastFreePosition(), $tab],
	  [new InsertionIntoSortedResources(), [
		  (new Video())->setName('Film1'),
		  (new Video())->setName('Film2'),
		  (new Image())->setName('Image1')
	      ]]
      ];
   }

   
}
