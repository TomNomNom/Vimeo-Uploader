#!/usr/bin/env php
<?php
//////////
// Init //
//////////
$settings = require __DIR__.'/../Include/Init.php';

$loggerFactory = new \Factory\Logger($settings);
$log = $loggerFactory->make();

$clientFactory = new \Factory\Vimeo($settings);

// Assume first (and only) argument as directory
if ($argc < 2){
  $log->err('No directory specified; exiting');
  exit(1);
}
$directory = $argv[1];

//////////
// Main //
//////////

$log->info("Looking for video files in [{$directory}]");

$i = new DirectoryIterator($directory);

foreach ($i as $file){
  $fullPath = realpath($file->getPathname());
  if (!$file->isFile()){
    $log->debug("Skipping non-file [{$fullPath}]");
    continue;
  }
  if (!$file->isReadable()){
    $log->warn("Skipping non-readable file [{$fullPath}]");
    continue;
  }

  $log->info("Attempting upload of [{$fullPath}]");
  
  $cmd = __DIR__."/UploadSingle.php ".escapeshellarg($fullPath);

  passthru($cmd, $returnValue);

}

