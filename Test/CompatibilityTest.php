<?php
namespace Test;

class CompatibilityTest extends \PHPUnit_Framework_TestCase {
  public function testCurl(){
    $this->assertTrue(
      is_callable('curl_init'), 
      "curl_init is not callable. PHP must be configured with --with-curl"
    ); 
  }
}

