<?php
namespace Test;

// We're testing the functionality of the abstract logger; so we just test the mock directly
class LoggerTest extends \PHPUnit_Framework_TestCase {
  public function testLevelEmerge(){
    $l = new Mock\Logger("EMERGE"); 

    $l->emerge('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_EMERGE);

    // Check next level up doesn't log
    $l->alert('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_EMERGE);
  }

  public function testLevelAlert(){
    $l = new Mock\Logger("ALERT"); 

    $l->alert('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_ALERT);

    // Check next level up doesn't log
    $l->crit('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_ALERT);

    // Check one level below does log
    $l->emerge('three');
    $this->assertEquals(trim($l->getLastMsg()), 'three');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_EMERGE);
  }

  public function testLevelCrit(){
    $l = new Mock\Logger("CRIT"); 

    $l->crit('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_CRIT);

    // Check next level up doesn't log
    $l->err('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_CRIT);

    // Check one level below does log
    $l->alert('three');
    $this->assertEquals(trim($l->getLastMsg()), 'three');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_ALERT);
  }

  public function testLevelErr(){
    $l = new Mock\Logger("ERR"); 

    $l->err('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_ERR);

    // Check next level up doesn't log
    $l->warn('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_ERR);

    // Check one level below does log
    $l->crit('three');
    $this->assertEquals(trim($l->getLastMsg()), 'three');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_CRIT);
  }

  public function testLevelWarn(){
    $l = new Mock\Logger("WARN"); 

    $l->warn('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_WARN);

    // Check next level up doesn't log
    $l->notice('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_WARN);

    // Check one level below does log
    $l->err('three');
    $this->assertEquals(trim($l->getLastMsg()), 'three');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_ERR);
  }

  public function testLevelNotice(){
    $l = new Mock\Logger("NOTICE"); 

    $l->notice('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_NOTICE);

    // Check next level up doesn't log
    $l->info('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_NOTICE);

    // Check one level below does log
    $l->warn('three');
    $this->assertEquals(trim($l->getLastMsg()), 'three');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_WARN);
  }

  public function testLevelInfo(){
    $l = new Mock\Logger("INFO"); 

    $l->info('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_INFO);

    // Check next level up doesn't log
    $l->debug('two');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_INFO);

    // Check one level below does log
    $l->notice('three');
    $this->assertEquals(trim($l->getLastMsg()), 'three');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_NOTICE);
  }

  public function testLevelDebug(){
    $l = new Mock\Logger("DEBUG"); 

    $l->debug('one');
    $this->assertEquals(trim($l->getLastMsg()), 'one');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_DEBUG);

    // Check one level below does log
    $l->info('two');
    $this->assertEquals(trim($l->getLastMsg()), 'two');
    $this->assertEquals(trim($l->getLastLevel()), \Logger::LEVEL_INFO);
  }
}

