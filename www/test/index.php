<?php
error_reporting(E_ALL);

require '../vendor/autoload.php';

echo("Trying to create video");

$ffmpeg = \FFMpeg\FFMpeg::create([
    'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
    'ffprobe.binaries' => '/usr/bin/ffprobe'
]);

// $ffmpeg = FFMpeg\FFMpeg::create();
$video = $ffmpeg->open('test-input.mp4');
// $video
//     ->filters()
//     ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
//     ->synchronize();

// $video
//     ->save(new FFMpeg\Format\Video\X264(), 'export/export-x264.mp4')
//     ->save(new FFMpeg\Format\Video\WMV(), 'export/export-wmv.wmv')
//     ->save(new FFMpeg\Format\Video\WebM(), 'export/export-webm.webm');

$format= new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264');
$video->save($format, 'test-output.mp4');
?>
