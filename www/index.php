<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="app/css/style.css"/>
        <title>Photos</title>
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    </head>
    <body>

<?php
error_reporting(E_ALL);

include 'app/config.php';
include 'app/functions.php';


$album = isset($_GET['a']) ? $_GET['a'] : null;

if ($album) :
        include 'app/views/view-album.php';
else :
        include 'app/views/view-index.php';
    ?>


<?php endif; ?>
</body>
</html>
