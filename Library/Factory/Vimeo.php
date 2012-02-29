<?php
namespace Factory;

class Vimeo extends \Factory {
  protected $settings;

  public function __construct(\StdClass $settings){
    $this->settings = $settings;
  }

  public function make(){
    if ($this->haveToken()){
      $client = new \Vimeo\Client(
        $this->settings->vimeo['consumer_key'], 
        $this->settings->vimeo['consumer_secret'],
        $this->settings->vimeo['token'],
        $this->settings->vimeo['token_secret']
      );
    } else {
      $client = new \Vimeo\Client(
        $this->settings->vimeo['consumer_key'], 
        $this->settings->vimeo['consumer_secret']
      );
    }

    return $client;
  }

  public function haveToken(){
    if (!isset($this->settings->vimeo['token'])) return false;
    if (!$this->settings->vimeo['token']) return false;
    if (!isset($this->settings->vimeo['token_secret'])) return false;
    if (!$this->settings->vimeo['token_secret']) return false;
    return true;
  }
}

