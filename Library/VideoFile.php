<?php
require __DIR__.'/GetID3/getid3.php';

class VideoFile {
  protected $filename;
  protected $id3 = null;

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
    // Ghetto; TODO: refactor
    if (!$this->id3){
      $getID3 = new getID3();
      $info = $getID3->analyze($this->filename);
      getid3_lib::CopyTagsToComments($info);
      $info = isset($info['comments_html'])? $info['comments_html'] : array();
      $info = array_map(function($comment){
        return array_pop($comment);
      }, $info);

      $this->id3 = $info;
    }

    return $this->id3;
  }

  public function getTitle(){
    $id3 = $this->getID3();
    if (!isset($id3['title'])){
      // Use the filename
      $title = new SplFileInfo($this->filename);
      $title = $title->getFilename();
    } else {
      $title = $id3['title'];
    }
    return $title;
  }

  public function getDescription(){
    $id3 = $this->getID3();
    if (!isset($id3['comment'])){
      $description = 'No description';
    } else {
      $description = $id3['comment'];
    }
    return $description;
  }
}

