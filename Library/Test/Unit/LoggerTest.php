<?php
namespace Test\Unit;

// We're testing the functionality of the abstract logger; so we just test the mock directly
class LoggerTest extends \PHPUnit_Framework_TestCase {
  public function testLevelEmerge(){
    $l = new \Test\Mock\Logger("EMERGE"); 

    $l->emerge('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_EMERGE, "Written log level was malformed");

    // Check next level up doesn't log
    $l->alert('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");
  }

  public function testLevelAlert(){
    $l = new \Test\Mock\Logger("ALERT"); 

    $l->alert('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_ALERT, "Written log level was malformed");

    // Check next level up doesn't log
    $l->crit('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");

    // Check one level below does log
    $l->emerge('three');
    $this->assertEquals($l->getLastMsg(), 'three', "Log written below current level but had no effect");
  }

  public function testLevelCrit(){
    $l = new \Test\Mock\Logger("CRIT"); 

    $l->crit('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_CRIT, "Written log level was malformed");

    // Check next level up doesn't log
    $l->err('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");

    // Check one level below does log
    $l->alert('three');
    $this->assertEquals($l->getLastMsg(), 'three', "Log written below current level but had no effect");
  }

  public function testLevelErr(){
    $l = new \Test\Mock\Logger("ERR"); 

    $l->err('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_ERR, "Written log level was malformed");

    // Check next level up doesn't log
    $l->warn('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");

    // Check one level below does log
    $l->crit('three');
    $this->assertEquals($l->getLastMsg(), 'three', "Log written below current level but had no effect");
  }

  public function testLevelWarn(){
    $l = new \Test\Mock\Logger("WARN"); 

    $l->warn('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_WARN, "Written log level was malformed");

    // Check next level up doesn't log
    $l->notice('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");

    // Check one level below does log
    $l->err('three');
    $this->assertEquals($l->getLastMsg(), 'three', "Log written below current level but had no effect");
  }

  public function testLevelNotice(){
    $l = new \Test\Mock\Logger("NOTICE"); 

    $l->notice('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_NOTICE, "Written log level was malformed");

    // Check next level up doesn't log
    $l->info('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");

    // Check one level below does log
    $l->warn('three');
    $this->assertEquals($l->getLastMsg(), 'three', "Log written below current level but had no effect");
  }

  public function testLevelInfo(){
    $l = new \Test\Mock\Logger("INFO"); 

    $l->info('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_INFO, "Written log level was malformed");

    // Check next level up doesn't log
    $l->debug('two');
    $this->assertEquals($l->getLastMsg(), 'one', "Log written at above current level should have no effect");

    // Check one level below does log
    $l->notice('three');
    $this->assertEquals($l->getLastMsg(), 'three', "Log written below current level but had no effect");
  }

  public function testLevelDebug(){
    $l = new \Test\Mock\Logger("DEBUG"); 

    $l->debug('one');
    $this->assertEquals($l->getLastMsg(), 'one', "Written log message was malformed");
    $this->assertEquals($l->getLastLevel(), \Logger::LEVEL_DEBUG, "Written log level was malformed");

    // Check one level below does log
    $l->info('two');
    $this->assertEquals($l->getLastMsg(), 'two', "Log written below current level but had no effect");
  }
}

