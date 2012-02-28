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

try {
  $log->debug('Fetching user upload quota');
  $response = $client->call("vimeo.videos.upload.getQuota");
} catch (\Vimeo\Exception $e){
  switch($e->getCode()){
    case 701:
      $log->err("Your API key dosen't have uploader access; you need to request it.");
      break;

    case 302:
      $log->err('Your token and/or token_secret is invalid; try running ./Scripts/Authorize.php');
      break;

    case 100:
      $log->err("Your consumer keys are invalid. Please make sure you have specified them in config.ini");
      break;

    default:
      $log->err("An unexpected error occured [".$e->getCode()."] (".$e->getMessage().")");
  }
  exit(1);
}

// Check the user's remaining quota before attempting upload
$freeSpace = $response->user->upload_space->free;
$log->debug("User has {$freeSpace} bytes of free space");

$file = new VideoFile($filename);
$filename = realpath($filename);
$uploadWorked = false;

if ($file->getSize() > $freeSpace){
  $log->err("[{$filename}] ({$file->getSize()} bytes) is larger than quota ({$freeSpace} bytes)");
}

$hookResponse = $executeHooks('Preupload', $filename);
if (!$hookResponse){
  $log->warn("At least one hook had a non-zero return code for [{$filename}]; will not attempt upload");
  continue;
}

// Do the actual upload here <- Not here whilst in development

if ($uploadWorked){
  $executeHooks('Postupload', $filename);
} else {
  $log->err("Failed to upload [{$filename}]");
  exit(1);
}

exit(0);
