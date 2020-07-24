<?php


function get_file_type($asset_ext)
{
    $val = null;
    if (in_array($asset_ext, ['mp4', 'mov', 'ogv'])) {
        $val = 'video';
    }
    if (in_array($asset_ext, ['jpg', 'png', 'gif'])) {
        $val = 'image';
    }
    if (in_array($asset_ext, ['txt'])) {
        $val = 'text';
    }
    return $val;
}

function get_file_contents($text_file_path)
{
    $contents = '';
    $fh = fopen($text_file_path, 'r');
    while ($line = fgets($fh)) :
        $contents .= $line . '<br />';
    endwhile;
    fclose($fh);
    return $contents;
}


function string_to_title($str)
{
    return ucwords(str_replace('-', ' ', $str));
}

function format_date($string, $file_date_format, $date_output_format)
{
    $date = DateTime::createFromFormat($file_date_format, $string);
    return $date->format($date_output_format);
}

function extract_album_date($album_dir_string, $file_date_format, $date_output_format)
{
    $prefix_length = 8;
    $date_string = substr($album_dir_string, 0, $prefix_length);
    return format_date($date_string, $file_date_format, $date_output_format);
}

function extract_album_title($album_dir_string, $file_date_format)
{
    $prefix_length = 8;
    $title =  substr($album_dir_string, $prefix_length);
    return string_to_title($title);
}

function get_albums($path)
{
    foreach (glob($path . "/*", GLOB_ONLYDIR) as $dir_full_path) {
        $exclude = ["app"];

        if (!in_array($dir_full_path, $exclude)) {
            $dir_name = str_replace($path, '', $dir_full_path);
            $dir_paths[] = $dir_name;
        }
    }
    rsort($dir_paths);
    return $dir_paths;
}


function generate_video($src_path)
{
    $file_dir = pathinfo($src_path)['dirname'];
    $file_name = pathinfo($src_path)['filename'];
    $file_ext = pathinfo($src_path)['extension'];

    // Create the /videos sub-directory if it doesn't exist
    $videos_dir = $file_dir . '/' . 'videos';
    if (!file_exists($videos_dir)) :
        mkdir($videos_dir, 0777, true);
    endif;

    $dest_path = $file_dir . '/videos/' . $file_name . '__720' . '.mp4';

    // Generate the 720p mp4 if it doesn't exist
    if (! file_exists($dest_path)) :
        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe'
        ]);
        if ($ffmpeg) :
            $video = $ffmpeg->open($src_path);
            // Avoid an Uncaught Exception error by passing in codecs:
            // https://github.com/PHP-FFMpeg/PHP-FFMpeg/issues/639#issuecomment-493671318
            $format= new \FFMpeg\Format\Video\X264('aac', 'libx264');

            $format
                ->setKiloBitrate(1000)
                ->setAudioChannels(2)
                ->setAudioKiloBitrate(256);
            $video->filters()->resize(new FFMpeg\Coordinate\Dimension(1280, 720))->synchronize();
            $video->save($format, $dest_path);
        else :
            echo ("FFMPEG or PHP-FFMPEG not installed");
        endif;
    endif;

}

// https://davidwalsh.name/create-image-thumbnail-php
function make_thumb($src, $dest, $desired_width)
{
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


function get_album_assets($album_path)
{
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

function video_src($video_path)
{
    $file_dir = pathinfo($video_path)['dirname'];
    $file_name = pathinfo($video_path)['filename'];
    $file_ext = pathinfo($video_path)['extension'];

    $resized_path = $file_dir . '/videos/' . $file_name . '__720' . '.mp4';

    return $resized_path;

}

function responsive_img_markup($img_path, $sizes)
{

    list($width, $height) = getimagesize($img_path);
    if ($width && $height) :
        $ratio = $height / $width;
        $presize_style = 'padding-top: ' . $ratio * 100 . '%';
    endif;

    $is_portrait = $ratio < 1;
    $is_square = $ratio == 1;

    $classes = '';

    if ($is_portrait) :
        $classes .= ' shape-landscape';
    elseif ($is_square) :
        $classes .= ' shape-square';
    else :
        $classes .= ' shape-portrait';
    endif;

    $file_name = pathinfo($img_path)['filename'];
    $file_dir = pathinfo($img_path)['dirname'];
    $file_ext = pathinfo($img_path)['extension'];

    $markup = '';

    if ($presize_style) :
        $markup .= "<div class=\"presize\" style=\"$presize_style\">";
    endif;

    $markup .= "<img loading=\"lazy\" data-ratio=\"$ratio\" class=\"$classes\"" ;
    // $markup .= " sizes=\"(min-width: 800px) 45vw, 100vw\"";
    $markup .= " sizes=\"100vw\"";

    $i=0;
    foreach ($sizes as $size) :
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

    if ($presize_style) :
        $markup .= '</div>';
    endif;

    return $markup;
}


