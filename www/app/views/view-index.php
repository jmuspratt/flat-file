<?php
?>
    <h1>Albums<h1>

<?php
$albums = get_albums($albums_path);
foreach ($albums as $album) :
    $album_path = str_replace('.', '', $album);
    $album_path = str_replace('/', '', $album_path);
    // $date_prefix = $album_path ...
    // $album_path = $album;

?>
<li><a href="?a=<?php echo $album_path;?>"><?php echo $album_path; ?></li>

<?php
endforeach;
// list albums
?>
