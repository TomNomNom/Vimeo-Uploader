<?php
abstract class Logger {
  const LEVEL_EMERGE = 0;
  const LEVEL_ALERT  = 1;
  const LEVEL_CRIT   = 2;
  const LEVEL_ERR    = 3;
  const LEVEL_WARN   = 4;
  const LEVEL_NOTICE = 5;
  const LEVEL_INFO   = 6;
  const LEVEL_DEBUG  = 7;

  protected $levelStrings = array(
    self::LEVEL_EMERGE => 'EMERGE',
    self::LEVEL_ALERT  => 'ALERT',
    self::LEVEL_CRIT   => 'CRIT',
    self::LEVEL_ERR    => 'ERR',
    self::LEVEL_WARN   => 'WARN',
    self::LEVEL_NOTICE => 'NOTICE',
    self::LEVEL_INFO   => 'INFO',
    self::LEVEL_DEBUG  => 'DEBUG'
  );

  protected $level;

  public function __construct($level){
    if (isset($this->levelStrings[$level])){
      // Already a valid level int
      $this->level = $level;
    } else {
      $this->level = $this->getLevelFromString($level); 
    }
  }

  abstract protected function log($msg, $level);

  protected function getLevelFromString($string){
    $levels = array_flip($this->levelStrings);
    if (!isset($levels[$string])){
      throw new \InvalidArgumentException("[{$string}] is not a valid log level");
    }
    return $levels[$string];
  }

  protected function getDateString($time){
    return date('Y-m-d H:i:s', $time);
  }

  protected function getLevelString($level){
    return $this->levelStrings[$level];
  }

  public function emerge($msg){
    if ($this->level < self::LEVEL_EMERGE) return;
    $this->log($msg, self::LEVEL_EMERGE);
  }

  public function alert($msg){
    if ($this->level < self::LEVEL_ALERT) return;
    $this->log($msg, self::LEVEL_ALERT);
  }

  public function crit($msg){
    if ($this->level < self::LEVEL_CRIT) return;
    $this->log($msg, self::LEVEL_CRIT);
  }

  public function err($msg){
    if ($this->level < self::LEVEL_ERR) return;
    $this->log($msg, self::LEVEL_ERR);
  }

  public function warn($msg){
    if ($this->level < self::LEVEL_WARN) return;
    $this->log($msg, self::LEVEL_WARN);
  }

  public function notice($msg){
    if ($this->level < self::LEVEL_NOTICE) return;
    $this->log($msg, self::LEVEL_NOTICE);
  }
  
  public function info($msg){
    if ($this->level < self::LEVEL_INFO) return;
    $this->log($msg, self::LEVEL_INFO);
  }

  public function debug($msg){
    if ($this->level < self::LEVEL_DEBUG) return;
    $this->log($msg, self::LEVEL_DEBUG);
  }

}
