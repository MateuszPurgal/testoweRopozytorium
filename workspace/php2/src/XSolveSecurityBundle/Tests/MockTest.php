<?php

namespace XSolveSecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use XSolveSecurityBundle\Shelf\AgataShelfFactory;

class MockTest extends WebTestCase {



   public function testxD() {
      // Create a stub for the SomeClass class.
      $agataShelfFactory = new AgataShelfFactory();
      $stub = $this->getMockBuilder('XSolveSecurityBundle\Shelf\AgataShelfFactory')
	      ->getMock();

      // Configure the stub.

        $stub->expects($this->any())
	      ->method('create')
	      ->will($this->returnValue($agataShelfFactory));
      // Calling $stub->doSomething() will now return
      // 'foo'.
      $this->assertEquals($agataShelfFactory, $stub->create());
   }

}
