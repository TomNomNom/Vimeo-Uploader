#!/usr/bin/env php
<?php
define('STORE_FILE', '/tmp/vimeo-upload-store.php');

$filename = $argv[1];
$hash = md5_file($filename);

if (file_exists(STORE_FILE)){
  $store = require STORE_FILE;
} else {
  // If there's no store the file hasn't been uploaded
  exit(0);
}

if (isset($store[$hash])){
  // The file has already been uploaded
  exit(1);
}

// If we've got to here then the file hasn't been uploaded before
exit(0);
