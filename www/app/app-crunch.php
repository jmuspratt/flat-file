<?php
?>

<div class="view-admin view">
<h2>Admin</h2>
<?php

$albums = get_albums(ALBUMS_PATH);
foreach ($albums as $album) :
    $album_path = str_replace('/', '', str_replace('.', '', $album));
    ?>
    <section class="view-admin__group">

    <h2 class="view-admin__head">Scanning <?php echo $album_path; ?></h2>
    <?php
        $album_assets = get_album_assets(ALBUMS_PATH . '/' . $album_path);

    foreach ($album_assets as $asset_path) : ?>
        <ul class="view-admin__report">
        <?php
            $asset_ext = strtolower(pathinfo($asset_path, PATHINFO_EXTENSION));
            $file_type = get_file_type($asset_ext);
            $file_name = pathinfo($asset_path)['filename'];
        if ($file_type === 'video') :
                echo ("<li>🎥 Video: $file_name <br />");
                generate_video($asset_path, true);
                echo ("</li>");
        elseif ($file_type === 'image') :
                echo ("<li>📸 Image: $file_name <br />");
                generate_thumbs($asset_path, $thumb_sizes, true);
                echo ("</li>");
        elseif ($file_type === 'text') :
                echo ("<li>🗒️ Text file: $file_name</li>");
        else :
                echo ("<li>⚠️ Unrecognized file type</li>");
        endif; ?>
            </ul>
    <?php endforeach; ?>
    </section>
<?php endforeach; ?>

