<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="app/css/style.css"/>
        <title>Photos</title>
    </head>
    <body>

<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';
include 'app/config.php';
include 'app/functions.php';

$album_name = isset($_GET['a']) ? $_GET['a'] : null;


if ($album_name) :
        include 'app/views/view-album.php';
else :
        include 'app/views/view-index.php';
endif;
?>

</body>
</html>
