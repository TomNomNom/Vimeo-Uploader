<?php
namespace Test\Mock;

class Logger extends \Logger {
  protected $lastMsg   = '';
  protected $lastLevel = null;

  public function log($msg, $level){
    $this->lastMsg   = $msg;
    $this->lastLevel = $level;
  }

  public function getLastMsg(){
    return $this->lastMsg;
  }
  public function getLastLevel(){
    return $this->lastLevel;
  }
}

