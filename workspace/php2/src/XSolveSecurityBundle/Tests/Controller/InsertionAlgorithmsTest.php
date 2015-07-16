<?php

namespace XSolveSecurityBundle\Tests\Controller;

use XSolveSecurityBundle\Models\Shelf;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use XSolveSecurityBundle\Security\PasswordChanger;
use XSolveSecurityBundle\Entity\User;
use XSolveSecurityBundle\Entity\Video;
use XSolveSecurityBundle\Entity\Image;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtFirstFreePosition;
use XSolveSecurityBundle\InsertionAlghoritms\InsertAtLastFreePosition;
use XSolveSecurityBundle\InsertionAlghoritms\InsertionIntoSortedResources;

class DefaultControllerTest extends WebTestCase {

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
      $shelf = new Shelf(6, $algorithm);
      $this->putDataIntoShelf($shelf, $this->provideData());

      $this->assertEquals($data, $shelf->getAllElements());
   }

   /**
    * @dataProvider provideAllAlgorithms
    */
   public function testShelfSize($algorithm) {
      $shelf = new Shelf(6, $algorithm);
      $data = [new Image(), new Video()];
      $this->putDataIntoShelf($shelf, $data);

      $this->assertEquals(2, $shelf->getSize());
   }

    /**
    * @expectedException OutOfRangeException
    * @expectedExceptionMessage Out of range shelf
    */
   public function testShelfOverSize() {
      $shelf = new Shelf(1, new InsertAtFirstFreePosition());
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

}
