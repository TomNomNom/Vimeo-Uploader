#!/usr/bin/env php
<?php
$settings = require __DIR__.'/Include/Init.php';

if (
  isset($settings->vimeo['token']) ||
  isset($settings->vimeo['token_secret']) 
  ){

  echo "It looks like you've already authorized your account!\n\n";
  echo "If you need to re-authorize your account just remove the "
      ."'token' and 'token_secret' settings from your config.ini and re-run this script.\n\n";
  
  exit(0);
}

$client = new \Vimeo\Client(
  $settings->vimeo['consumer_key'], 
  $settings->vimeo['consumer_secret']
);

echo "Please visit this URL and allow the application to access your account: \n\n";
echo "  ".$client->getAuthUrl('write');
echo "\n\n";
echo "When given a code, copy and paste it here and press return: ";

$fh = fopen('php://stdin', 'r');
$gotCode = false;
while (!$gotCode){
  $code = trim(fgets($fh));
  if ($code){
    $gotCode = true;
  } else {
    echo "\nPlease paste the code here and press return: ";
  }
}
fclose($fh);

echo "\nFetching access token for code [{$code}]...\n\n";

$accessToken = $client->getAccessToken($code);

if (
  !isset($accessToken['oauth_token']) || 
  !isset($accessToken['oauth_token_secret'])
  ){
  echo "There seems to have been a problem fetching an access token. Please try again.\n\n";
  exit(1);
}

echo "It worked! Please edit the [vimeo] section of your config.ini file so that the "
    ."'token' and 'token_secret' settings read as follows:\n\n";
echo "  token        = \"{$accessToken['oauth_token']}\"\n";
echo "  token_secret = \"{$accessToken['oauth_token_secret']}\"\n";

echo "\n\n";

exit(0);
