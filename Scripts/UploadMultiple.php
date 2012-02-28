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

$executeHooks = function ($stage, $videoFile) use($log){
  $returnValues = array();
  $stage = ucFirst(strToLower($stage));

  $log->info("Running {$stage} hooks for [{$videoFile}]");
  $i = new DirectoryIterator(__DIR__."/../Hooks/{$stage}");

  foreach ($i as $file){
    if (!$file->isFile()) continue;

    if (!$file->isExecutable()){
      $log->debug("Skipping non-executable {$stage} hook [".$file->getPathname()."]");
      continue;
    }
    
    $log->info("Executing {$stage} hook [".$file->getPathname()."]");
    $cmd = $file->getPathname().' '.escapeshellarg($videoFile);
    exec($cmd, $output, $returnValue);
    if ($returnValue != 0){
      $log->warn('['.$file->getPathname().'] had a non-zero return code');
    }
    $returnValues[] = $returnValue;
  }
  if (array_sum($returnValues) > 0){
    return false;
  }
  return true;
};

//////////
// Main //
//////////

$log->info("Looking for video files in [{$directory}]");

$i = new DirectoryIterator($directory);

foreach ($i as $file){
  if (!$file->isFile()){
    $log->debug('Skipping non-file ['.$file->getPathname().']');
    continue;
  }
  if (!$file->isReadable()){
    $log->warn('Skipping non-readable file ['.$file->getPathname().']');
    continue;
  }

  $hookResponse = $executeHooks('Preupload', $file->getPathname());
  if (!$hookResponse){
    $log->warn("At least one hook had a non-zero return code for [".$file->getPathname()."]; will not attempt upload");
    continue;
  }
  $log->info('Attempting upload of ['.$file->getPathname().']');
  
  $cmd = __DIR__."/UploadSingle.php ".escapeshellarg($file->getPathname());

  passthru($cmd, $returnValue);

  if ($returnValue == 0){
    $executeHooks('Postupload', $file->getPathname());
  }
}

