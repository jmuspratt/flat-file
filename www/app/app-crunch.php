<?php
?>

<div class="view-admin view">
<h2>Admin</h2>
<?php

$albums = get_albums(ALBUMS_PATH);
foreach ($albums as $album) :
    ?>
    <section class="view-admin__group">

    <h2 class="view-admin__head">Scanning <?php echo $album["id"]; ?></h2>
    <?php
        $album_assets = get_album_assets($album["path"]);

    foreach ($album_assets as $asset_info) : ?>
        <ul class="view-admin__report">
        <?php
        if ($asset_info["file_type"] === 'video') :
                echo ("<li>🎥 Video: $asset_info[filename] <br />");
                generate_video($asset_info["path"], true);
                echo ("</li>");
        elseif ($asset_info["file_type"] === 'image') :
                echo ("<li>📸 Image: $asset_info[filename]<br />");
                generate_thumbs($asset_info["path"], true);
                echo ("</li>");
        elseif ($asset_info["file_type"] === 'text') :
                echo ("<li>🗒️ Text file: $asset_info[filename]</li>");
        else :
                echo ("<li>⚠️ Unrecognized file type</li>");
        endif; ?>
            </ul>
    <?php endforeach; ?>
    </section>
<?php endforeach; ?>

