<?php
namespace Logger;

class Screen extends \Logger {
  protected function log($msg, $level){
    $level = $this->getLevelString($level);

    $line = "{$level}: {$msg}\n";
    echo $line;
  }
}

