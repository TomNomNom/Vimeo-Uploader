#!/usr/bin/env php
<?php
/**
 * TVYV - Transfer Video from Youtube to Vimeo
 * Original author: John McLear <john@mclear.co.uk>
 * Modified by: Tom Hudson <mail@tomnomnom.com>
 */
$settings = require __DIR__.'/include/init.php';
$messages = require __DIR__.'/include/messages.php';

$logFactory = new \Factory\Logger($settings->log);
$log = $logFactory->make();

$log->warn('I am a warning');

if ($argc == 1){
  stderr($messages->help['general']);
  exit(1);
}

$command = $argv[1];
if ($command == 'help'){
  if (isset($messages->help[$argv[2]])){
    // Command specific help
    stdout($messages->help[$argv[2]]);
  } else {
    stdout($messages->help['general']);
  }
  exit(0);
}
