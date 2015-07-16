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
use XSolveSecurityBundle\Shelf\AgataShelfFactory;
use XSolveSecurityBundle\Shelf\IkeaShelfFactory;
use XSolveSecurityBundle\Shelf\BodzioShelfFactory;
use XSolveSecurityBundle\Shelf\BlackRedWhiteShelfFactory;

class ShelFactoryTest extends WebTestCase {

   /**
    * @dataProvider provideShelfsAndCapacity
    */
   public function testShellFactory($shelf, $size) {
      $this->assertEquals($shelf->getCapacity(), $size);
   }

   /**
    * @dataProvider provideShelfsAndTable
    */
   public function testShellAlgorithms($shelf, $data) {
      $this->putDataIntoShelf($shelf, $this->provideHalfData());
      $this->assertEquals($data, $shelf->getAllElements());
   }

   /**
    * @expectedException InvalidArgumentException
    * @expectedExceptionMessage fdsfsd is not valid shelf
    */
   public function testUnexpectedNameShelf() {
      (new SimpleFactory())->createShelf('fdsfsd');
   }

   public function putDataIntoShelf(Shelf $shelf, $data) {
      for ($i = 0; $i < count($data); $i++) {
	 if ($data[$i]) {
	    $shelf->putElementOnShelf($data[$i]);
	 }
      }
      return $shelf;
   }

   public function provideHalfData() {
      return [
	  (new Video())->setName('Film1'),
	  (new Image())->setName('Image1'),
	  (new Video())->setName('Film2')
      ];
   }

   public function provideShelfsAndTable() {
      $insertAtLastFreePosition[12] = (new Video())->setName('Film2');
      $insertAtLastFreePosition[13] = (new Image())->setName('Image1');
      $insertAtLastFreePosition[14] = (new Video())->setName('Film1');

      $insertAtFirstFreePosition[0] = (new Video())->setName('Film1');
      $insertAtFirstFreePosition[1] = (new Image())->setName('Image1');
      $insertAtFirstFreePosition[2] = (new Video())->setName('Film2');

      $insertionIntoSortedResources[0] = (new Video())->setName('Film1');
      $insertionIntoSortedResources[1] = (new Video())->setName('Film2');
      $insertionIntoSortedResources[2] = (new Image())->setName('Image1');

      return [
	  [ (new SimpleFactory())->createShelf('AgataShelf'), $insertAtFirstFreePosition],
	  [(new SimpleFactory())->createShelf('BlackRedWhiteShelf'), $insertAtLastFreePosition],
	  [(new SimpleFactory())->createShelf('BodzioShelf'), $insertionIntoSortedResources],
	  [(new SimpleFactory())->createShelf('IkeaShelf'), $insertAtFirstFreePosition],
	  [(new AgataShelfFactory())->create(), $insertAtFirstFreePosition],
	  [(new BlackRedWhiteShelfFactory())->create(), $insertAtLastFreePosition],
	  [(new BodzioShelfFactory())->create(), $insertionIntoSortedResources],
	  [(new IkeaShelfFactory())->create(), $insertAtFirstFreePosition]
      ];
   }

   function provideShelfsAndCapacity() {
      return [
	  [ (new SimpleFactory())->createShelf('AgataShelf'), 8],
	  [(new SimpleFactory())->createShelf('BlackRedWhiteShelf'), 15],
	  [(new SimpleFactory())->createShelf('BodzioShelf'), 6],
	  [(new SimpleFactory())->createShelf('IkeaShelf'), 6],
	  [(new AgataShelfFactory())->create(), 8],
	  [(new BlackRedWhiteShelfFactory())->create(), 15],
	  [(new BodzioShelfFactory())->create(), 6],
	  [(new IkeaShelfFactory())->create(), 6]
      ];
   }

}
