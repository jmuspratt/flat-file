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


function date_format_length($format)
{
    $example_output = format_date("2020-01-01", 'Y-m-d', $format);
    return mb_strlen($example_output);
}

function format_date($string, $input_date_format, $output_date_format)
{
    $date = DateTime::createFromFormat($input_date_format, $string);
    return $date->format($output_date_format);
}

function extract_date($album_dir_string, $input_date_format)
{
    $prefix_length = date_format_length($input_date_format);
    $date_string = substr($album_dir_string, 0, $prefix_length);
    return format_date($date_string, $input_date_format, OUTPUT_DATE_FORMAT);
}

function extract_title($album_dir_string, $input_date_format)
{
    $prefix_length = date_format_length($input_date_format);
    $title = substr($album_dir_string, $prefix_length);
    return string_to_title($title);
}

function get_album_info_from_id($album_id)
{
    $album_url = ROOT_URL . '/?a=' . $album_id;
    $album_path = ALBUMS_PATH . '/' . $album_id;
    $album_title = extract_title($album_id, ALBUM_DATE_FORMAT, OUTPUT_DATE_FORMAT);
    $album_date = extract_date($album_id, ALBUM_DATE_FORMAT, OUTPUT_DATE_FORMAT);
    $album_asset_count = count(get_album_assets($album_path));

    $album_info = array(
        "id" => $album_id,
        "url" => $album_url,
        "path" => $album_path,
        "album_asset_count" => $album_asset_count,
        "display_title" => $album_title,
        "display_date" => $album_date
    );

    return $album_info;
}

function get_albums($path) {
    $albums = [];
    foreach (glob($path . "/*", GLOB_ONLYDIR) as $dir_full_path) :
        $album_id = basename($dir_full_path);
        $album_info = get_album_info_from_id($album_id);
        $albums[] = $album_info;
    endforeach;
    rsort($albums);
    return $albums;
}


function generate_video($src_path, $verbose = false)
{
    $file_dir = pathinfo($src_path)['dirname'];
    $file_name = pathinfo($src_path)['filename'];
    $file_ext = pathinfo($src_path)['extension'];

    // Create album sub-directory if it doesn't exist
    $new_album_dir = basename($file_dir);
    $cache_dir = ALBUMS_PATH_PROCESSED . '/' . $new_album_dir;
    if (!file_exists($cache_dir)) :
        mkdir($cache_dir, 0777, true);
    endif;

    $dest_path = $cache_dir . '/' . $file_name . '__720.mp4';

    // Generate the 720p mp4 if it doesn't exist
    if (! file_exists($dest_path)) :
        if ($verbose) :
            echo ("🛠️ Generating web-ready video file...");
        endif;


        // $ffmpeg = \FFMpeg\FFMpeg::create();
        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => FFMPEG_DIR . '/ffmpeg',
            'ffprobe.binaries' => FFMPEG_DIR . '/ffprobe'
        ]);
        if ($ffmpeg) :
            $video = $ffmpeg->open($src_path);
            // Avoid an Uncaught Exception error by passing in codecs:
            // https://github.com/PHP-FFMpeg/PHP-FFMpeg/issues/639#issuecomment-493671318
            $format = new \FFMpeg\Format\Video\X264('aac', 'libx264');

            $format
                ->setKiloBitrate(2500)
                ->setAudioChannels(2)
                ->setAudioKiloBitrate(256);
            $video->filters()->resize(new FFMpeg\Coordinate\Dimension(1280, 720))->synchronize();
            $video->save($format, $dest_path);
        else :
            echo ("FFMPEG or PHP-FFMPEG not installed");
        endif;
    else :
        if ($verbose) :
            echo ("✅ File already exists");
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
    $album_id = basename($album_path);
    foreach (glob($album_path . "/*") as $asset) :
        // exclude directories
        if (!is_dir($asset)) :
            $filename = pathinfo($asset)["basename"];
            $extension = strtolower(pathinfo($asset, PATHINFO_EXTENSION));
            $type = get_file_type($extension);
            $url = ROOT_URL . '/' . ALBUMS_DIR . '/' . $album_id . '/' . $filename;
            $album_id = basename($album_path);
            $assets[] = array(
                "album_id" => $album_id,
                "extension" => $extension,
                "filename" => $filename,
                "file_type" => $type,
                "path" => $asset,
                "url" => $url,
            );
        endif;
    endforeach;
    return $assets;
}

function generate_thumbs($src_path, $verbose = false)
{
    $file_dir = pathinfo($src_path)['dirname'];
    $file_name = pathinfo($src_path)['filename'];
    $file_ext = pathinfo($src_path)['extension'];

    $new_album_dir = basename($file_dir);
    // Create the thumbs directory if it doesn't exist
    $cache_dir = ALBUMS_PATH_PROCESSED . '/' . $new_album_dir;
    if (!file_exists($cache_dir)) :
        mkdir($cache_dir, 0777, true);
    endif;


    // For each size, generate the thumb unless it exists
    foreach (THUMB_SIZES as $size) {
        $output_path = $cache_dir. '/' . $file_name . '__' . $size . '.' . $file_ext;

        if (!file_exists($output_path)) :
            if ($verbose) :
                echo ("🛠️ Generating image for $file_name ($size px) <br />");
            endif;
            make_thumb($src_path, $output_path, $size);
        else :
            if ($verbose) :
                echo ("✅ Image size already exists: $file_name ($size px) <br />");
            endif;
        endif;
    }
}

function video_src($video_path)
{
    $file_name = pathinfo($video_path)['filename'];
    $file_dir = pathinfo($video_path)['dirname'];
    $file_ext = pathinfo($video_path)['extension'];

    $cache_dir = ALBUMS_DIR_PROCESSED . '/' . basename($file_dir);

    $resized_url = ROOT_URL . '/' . $cache_dir. '/'. $file_name . '__720.mp4';

    return $resized_url;
}

function responsive_img_markup($img_path)
{
    $ratio = null;
    $presize_value = null;

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

    $cache_dir = ALBUMS_DIR_PROCESSED . '/' . basename($file_dir) . '/';

    $markup = '';

    if ($presize_style) :
        $markup .= "<div class=\"presize\" style=\"$presize_style\">";
    endif;

    $markup .= "<img loading=\"lazy\" class=\"$classes\"" ;

    // TODO: add Sizes attribute that matches display width
    // $markup .= " sizes=\"(min-width: 960px) calc((100vw - 350px) / 2), (min-width: 1100px) calc(100vw - 350px), 100vw\"";

    $i=0;
    foreach (THUMB_SIZES as $size) :
        $thumb_path = ROOT_URL . '/' . $cache_dir . $file_name . '__' . $size . '.' . $file_ext;

        if ($i===0) :
            $markup .= " src=\"$thumb_path\"";
            $markup .= " srcset=\"";
        endif;
        // Continue with srcset values...
        $markup .= $thumb_path . ' ' . $size . 'w';

        // All but last value gets trailing comma
        if ($i < sizeof(THUMB_SIZES) - 1) :
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


