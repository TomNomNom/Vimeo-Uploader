<?php
namespace Factory;

class Logger extends \Factory {
  
  public function make(){
    switch ($this->settings->log['type']){
      case 'file':
        // Make relative files relative to the config file
        $file = $this->settings->log['file'];
        if (file_exists($file)){
          if (!is_writable($file)){
            throw new \InvalidArgumentException("[{$file}] is not writable");
          }
        } else {
          if (is_writeable(dirname($file))){
            touch($file);
          } else {
            throw new \InvalidArgumentException("[".dirname($file)."] is not writable; could not create log file");
          }
        }
        if (in_array(substr($file, 0, 2), array('./', '..'))){
          $file = __DIR__.'/../../'.$file; 
        }
        return new \Logger\File($this->settings->log['level'], $file);
        break;

      case 'screen':
        return new \Logger\Screen($this->settings->log['level']);
        break;

      case 'null':
      default:
        return new \Logger\Null($this->settings->log['level']);
        break;
    }
  }
}

