<?php

function display_string($str) {
    return ucwords(str_replace('-', ' ', $str));
}

function format_date($string, $file_date_format, $date_output_format) {
    $date = DateTime::createFromFormat($file_date_format, $string);
    return $date->format($date_output_format);
}

function extract_album_date($album_dir_string, $file_date_format, $date_output_format) {
    $prefix_length = 8;
    $date_string = substr($album_dir_string, 0, $prefix_length);
    return format_date($date_string, $file_date_format, $date_output_format);
}

function extract_album_title($album_dir_string, $file_date_format) {
    $prefix_length = 8;
    $title =  substr($album_dir_string, $prefix_length);
    return display_string($title);
}

function get_albums($path) {
    // echo "path is " . $path;
    foreach (glob($path . "/*", GLOB_ONLYDIR) as $dir_full_path) {
        $exclude = ["app"];

        if (!in_array($dir_full_path, $exclude)) {
            $dir_name = str_replace($path, '', $dir_full_path);
            $dir_paths[] = $dir_name;
        }
    }
    return $dir_paths;
}


// https://davidwalsh.name/create-image-thumbnail-php
function make_thumb($src, $dest, $desired_width) {

    // echo ("-----------");
    // echo ("src: $src <br />");
    // echo ("dest: $dest<br />");
    // echo ("-----------");

    /* read the source image */
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    imagejpeg($virtual_image, $dest);
}


function get_album_assets($album_path) {
    foreach (glob($album_path . "/*") as $asset) {
        if (!is_dir($asset)) {
            $assets[] = $asset;
        }
    }

    return $assets;
}

function generate_thumbs($src_path, $sizes)
{


    $file_dir = pathinfo($src_path)['dirname'];
    $file_name = pathinfo($src_path)['filename'];
    $file_ext = pathinfo($src_path)['extension'];
    // echo ("extension is ". $file_ext);

    // Create the thumbs directory if it doesn't exist
    $thumb_dir = $file_dir . '/' . 'thumbs';
    if (!file_exists($thumb_dir)) :
        mkdir($thumb_dir, 0777, true);
    endif;

    // For each size, generate the thumb unless it exists
    foreach ($sizes as $size) {
        $output_path = $file_dir . '/thumbs/' . $file_name . '__' . $size . '.' . $file_ext;

        if (!file_exists($output_path)) :
            make_thumb($src_path, $output_path, $size);
        endif;
    }
}

function responsive_img_markup($img_path, $sizes)
{
    $file_name = pathinfo($img_path)['filename'];
    $file_dir = pathinfo($img_path)['dirname'];
    $file_ext = pathinfo($img_path)['extension'];

    $markup = '<img loading="lazy"';
    $markup .= " sizes=\"(min-width: 800px) 45vw, 100vw\"";

    $i=0;
    foreach ( $sizes as $size ) :
        $thumb_path = $file_dir . '/thumbs/' . $file_name . '__' . $size . '.' . $file_ext;

        if ($i===0) :
            $markup .= " src=\"$thumb_path\"";
            $markup .= " srcset=\"";
        endif;
        // Continue with srcset values...
        $markup .= $thumb_path . ' ' . $size . 'w';

        // All but last value gets trailing comma
        if ($i < sizeof($sizes) - 1) :
            $markup .= ', ';
        endif;
        $i++;
    endforeach;

    $markup .= '" />';

    return $markup;
}

