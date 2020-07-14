<div class="view-album view">
    <?php
        // output album assets
        $album_title = extract_album_title($album, $file_date_format, $date_output_format);
        $album_date = extract_album_date($album, $file_date_format, $date_output_format);
        $album_assets = get_album_assets($albums_path . '/' . $album);

    ?>

    <header class="view-album__header">
        <p class="view-album__back"><a class="view-album__back-link btn" href="<?php echo $root_url; ?>">Back</a></p>
        <h1 class="view-album__title"><?php echo $album_title; ?></h1>
        <h2 class="view-album__date"><?php echo $album_date; ?></h2>
    </header>

    <section class="view-album__content">
        <?php
        foreach ($album_assets as $asset)  :
            $asset_path =  $asset;
            $asset_ext = strtolower(pathinfo($asset_path, PATHINFO_EXTENSION));
            $file_type = get_file_type($asset_ext);
            ?>

            <div class="view-album__item view-album__item--<?php echo $file_type; ?>">
            <?php if ($file_type) :
                if ($file_type === 'video') :
                    include 'asset-video.php';
                elseif ($file_type === 'image') :
                    include 'asset-image.php';
                elseif ($file_type === 'text') :
                    include 'asset-text.php';
                endif;
            ?>
            <?php else : ?>
            <!-- Error, uncrecognized file type: <?php echo $asset_path; ?> -->
            <?php endif; ?>
        </div>

        <?php endforeach; ?>
    </section>

</div>
