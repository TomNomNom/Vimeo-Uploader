#!/usr/bin/env php
<?php
define('STORE_FILE', '/tmp/vimeo-upload-store.php');

$filename = $argv[1];
$hash = md5_file($filename);

if (file_exists(STORE_FILE)){
  $store = require STORE_FILE;
} else {
  $store = array();
}

$store[$hash] = $filename;

$codeString = var_export($store, true);

$code = '<?php return '.$codeString.';';

file_put_contents(STORE_FILE, $code);
