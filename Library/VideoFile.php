<?php
class VideoFile {
  protected $filename;

  public function __construct($filename){
    if (!file_exists($filename)){
      throw new \InvalidArgumentException("[{$filename}] does not exist");
    }
    $this->filename = $filename;
  }

  public function getSize(){
    return filesize($this->filename);
  }
}

