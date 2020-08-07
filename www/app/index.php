<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css"/>
        <title>Photos</title>
    </head>
    <body>

<?php

require '../vendor/autoload.php';
include 'config.php';
include 'functions.php';


$crunch = isset($_POST['crunch']);

if ($crunch) :
    include 'app-crunch.php';
else :
    include 'app-admin.php';
endif;


?>




</body>
</html>
