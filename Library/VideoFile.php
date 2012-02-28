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

  public function getID3(){
    return id3_get_tag($this->filename);
  }

  public function getTitle(){
    // TODO: Get from ID3
    return 'Default title';
  }

  public function getDescription(){
    // TODO: Get from ID3
    return 'Default description';
  }
}

