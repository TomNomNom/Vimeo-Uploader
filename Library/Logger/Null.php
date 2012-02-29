<?php
namespace Logger;

class Null extends \Logger {
  protected function log($msg, $level){
    // Do nothing :)
  }
}

