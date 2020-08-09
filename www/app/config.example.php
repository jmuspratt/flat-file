<?php


define("ROOT_URL", "https://flatfile.ups.dock");
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);

define("ALBUMS_DIR", 'albums');
define("ALBUMS_DIR_PROCESSED", 'albums-processed');
define("ALBUMS_PATH", ROOT_PATH . "/" . ALBUMS_DIR);
define("ALBUMS_PATH_PROCESSED", ROOT_PATH . "/" . ALBUMS_DIR_PROCESSED);

// FFMPEG location
define('FFMPEG_DIR', "/usr/local/bin");

// Date Formats
define("ALBUM_DATE_FORMAT", "Y-m-d"); // 2020-01-31-My-Vacation
define("FILE_DATE_FORMAT", "Y-m-d-H-M-S"); // 2020-01-31-12-30-01.jpg
define("OUTPUT_DATE_FORMAT", 'F j, Y'); // January 1, 2020

//  Set width of image sizes to be generated from originals
define("THUMB_SIZES", [ 900, 1800, 2700, 3600 ]);
