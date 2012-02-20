<?php
namespace Factory;

class Logger extends \Factory {
  
  public function make(){
    switch ($this->settings['type']){
      case 'file':
        // Make relative files relative to the config file
        $file = $this->settings['file'];
        if (in_array(substr($file, 0, 2), array('./', '..'))){
          $file = __DIR__.'/../../'.$file; 
        }
        return new \Logger\File($this->settings['level'], $file);
        break;

      case 'null':
      default:
        return new \Logger\Null($this->settings['level']);
        break;
    }
  }
}

