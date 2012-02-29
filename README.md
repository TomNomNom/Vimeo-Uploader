# Vimeo Uploader

## Requirements
* Linux of some description
* PHP 5.3+
* PHP Curl
* Vimeo account

## Install instructions
* [Register a new application with Vimeo](http://vimeo.com/api/applications/new); be sure to request uploader access
* Download and extract [the code](https://github.com/TomNomNom/Vimeo-Uploader/tarball/master)
* Copy config.example.ini to config.ini
* Once your Vimeo application is approved update the consumer\_key and consumer\_secret settings in config.ini
* Run ./Scripts/Authorize.php and follow the instructions

## Usage instuctions
You may either upload a single video:

    ./Scripts/UploadSingle.php /path/to/video/file.mp4

Or upload videos from a directory:

    ./Scripts/UploadMultiple.php /directory/full/of/videos

## Hooks
All executable files in ./Hooks/Preupload will be executed before a video is uploaded. Each hook will be given
the full path to the video being uploaded as its only argument.

**If any hooks have a non-zero return code the video will *not* be uploaded.**

If the upload succeeds: all executable files in ./Hooks/Postupload will be executed. Each hook will be given 
the full path to the uploaded video as its only argument.

The suggested use-case for hooks is to store an MD5 hash of a file post-upload, and checking if the MD5 hash
of a file has already been stored on pre-upload to avoid uploading the same video twice. Some example hooks
written in PHP are provided that do just this; albeit in a simplistic manner. 

## Notes
* The script will always check your upload quota before uploading videos
