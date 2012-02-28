A simple way to mirror your videos from Youtube to Vimeo.  Designed by someone who doesn't trust a single point of failure for his data.

#IT DOES WUT?
This tool copies all of the videos from your Youtube account to a Vimeo account.

#LIMITATIONS
Vimeos API places a 15GB per week limit, we have to adhere to that.

#PIRATES!
Do not use this tool for replicating copywritten material.  This tool is designed so users can distribute their content safely. 

#GOOGLE STAFF
I know, I know..  This script isn't very "pro Youtube" but before you send me yet another email complaining please research my commitments to developing the open-web and online interopability.

#GETTING STARTED
* [Register for a Vimeo consumer and secret key at Vimeo.com](http://vimeo.com/api/applications/new)..   Wait for your keys..
* [Download this Tool](https://github.com/johnyma22/Transfer-Video-from-Youtube-to-Vimeo/tarball/master).  
* Extract the tar.gz file to a moist place
* Open up config.php
* Insert your vimeo keys and youtube username.
* Save and Close config.php
* Test by running index.php (php index.php)
* Once you are happy, change debug to false in config.php and add a cron job if you like

# Requirements
* PHP 5.3+
* PHP Curl
* PHP ID3 extension (http://www.php.net/manual/en/book.id3.php)

# Plan for changes
Make the system modular, where the interface between modules is command-line arguments
and return codes where possible. A facade will be provided for ease of use.

## Modules 
* Upload a single video to Vimeo
* Download a single video from Youtube

## Facade responsibilities
* Take a directory as an input and upload all contained videos to Vimeo
* Take a list of Youtube videos and download them into a specified directory

## Hooks
Hook scripts will be executed before and after uploading or downloading any single video. 
This is to enable more advanced flow control without restricting the programming language used to do so.

### Available hooks
* Pre-upload
* Post-upload
* Pre-download
* Post-download

### Pre-upload, post-upload and post-download arguments
* Path to the video file
* MD5 hash of the video file

### Pre-download arguments
* TBC

### Exit codes
In general, a non-zero exit code from a hook will prevent the next step 
from being carried out. For example: a pre-upload hook might check the MD5
hash of a file against a list of hashes from files that are known to have been 
uploaded already. If a match is found, a non-zero exit code would prevent the 
video from being uploaded a second time. A post-upload hook could 
store the hashes of successfully uploaded files in the aforementioned list. 
