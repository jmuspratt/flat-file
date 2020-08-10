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

    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);

    require 'vendor/autoload.php';
    include 'app/config.php';
    include 'app/functions.php';

    $album_id = isset($_GET['a']) ? $_GET['a'] : null;


if ($album_id) :
        include 'app/views/view-album.php';
else :
        include 'app/views/view-index.php';
endif;
    ?>

    <footer class="site-footer">
        <p class="site-credit">Built with <a href="https://github.com/jmuspratt/flat-file">Flat File</p>
    </footer>
</body>
</html>
