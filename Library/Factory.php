<?php
abstract class Factory {
  protected $settings;

  public function __construct($settings){
    $this->settings = $settings;
  }

  abstract public function make();
}

