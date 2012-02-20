<?php
namespace Logger;

class File extends \Logger {
  protected $file;

  protected $handle = null;

  public function __construct($level, $file){
    $this->file = $file;
    parent::__construct($level);
  }

  protected function log($msg, $level){
    if (is_null($this->handle)){
      $this->handle = fopen($this->file, 'a');
    }

    $level = $this->getLevelString($level);
    $date  = $this->getDateString(time());

    $line = "[{$date}] {$level}: {$msg}\n";
    fputs($this->handle, $line, strlen($line));
  }

  public function __destruct(){
    if (!is_null($this->handle)){
      fclose($this->handle);
    }
  }

}

