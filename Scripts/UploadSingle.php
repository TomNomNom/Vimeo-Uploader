#!/usr/bin/env php
<?php
//////////
// Init //
//////////
$settings = require __DIR__.'/../Include/Init.php';

$loggerFactory = new \Factory\Logger($settings);
$log = $loggerFactory->make();

$clientFactory = new \Factory\Vimeo($settings);
$client = $clientFactory->make();

// Assume first (and only) argument as filename
if ($argc < 2){
  $log->err('No filename specified');
  exit(1);
}
$filename = $argv[1];

//////////
// Main //
//////////

try {
  $log->debug('Fetching user upload quota');
  $response = $client->call("vimeo.videos.upload.getQuota");
} catch (\Vimeo\Exception $e){
  switch($e->getCode()){
    case 701:
      $log->err("Your API key dosen't have uploader access; you need to request it.");
      break;
    default:
      $log->err("An unknown error occured.");
  }
  exit(1);
}

// Check the user's remaining quota before attempting upload
$freeSpace = $response->user->upload_space->free;
$log->debug("User has {$freeSpace} bytes of free space");

$file = new VideoFile($filename);

if ($file->getSize() > $freeSpace){
  $log->err("[{$filename}] ({$file->getSize()} bytes) is larger than quota ({$freeSpace} bytes)");
}

//$id3 = $file->getID3();

$log->err("Failed to upload [$filename]");
exit(1);

