<?php
?>

<div class="view-admin view">
<h2>Admin</h2>
<?php

$albums = get_albums('../'.$albums_path);
foreach ($albums as $album) :
    $album_path = str_replace('/', '', str_replace('.', '', $album)); ?>

    <h2>Scanning <?php echo $album_path; ?></h2>
<table>
<tbody>
<?php
    $album_assets = get_album_assets('../' . $albums_path . '/' . $album_path);

    foreach ($album_assets as $asset_path) :
        $asset_ext = strtolower(pathinfo($asset_path, PATHINFO_EXTENSION));
        $file_type = get_file_type($asset_ext);
        ?>
        <tr>
            <td><?php echo $asset_path; ?></td>
    <?php
        if ($file_type === 'video') :
            echo ("<td>Video</td>");
            // generate_video($asset_path, $albums_path_processed);
        elseif ($file_type === 'image') :
            echo ("<td>Image</td>");
        //     generate_thumbs($asset_path, $albums_path_processed, $thumb_sizes);
        elseif ($file_type === 'text') :
            echo ("<td>Text file</td>");
        //     echo ("text file");
        else :
            echo ("<td>Unrecognized file type</td>");
        endif;
        echo ("</tr>");
    endforeach;
    ?>

<?php endforeach; ?>
</tbody>
</table>

