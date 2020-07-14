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
            <?php if ($file_type) : ?>
                <?php if ($file_type === 'video') : ?>
            <a href="<?php echo $asset_path; ?>" class="view-album__asset-link js-lightbox-trigger">
                <div class="view-album__asset view-album__asset--video">
                    <video class="view-album__video" autoplay loop muted playsinline>
                        <source  src="<?php echo $asset_path; ?>" />
                    </video>
                </div>
            </a>

            <?php elseif ($file_type === 'image') :
                // generate the thumbs for this image
                generate_thumbs($asset_path, $thumb_sizes);
            ?>
            <a href="<?php echo $asset_path; ?>" class="view-album__asset-link js-lightbox-trigger">
                <figure class="view-album__asset album__asset--figure">
                    <?php echo responsive_img_markup($asset_path, $thumb_sizes) ?>
                </figure>
            </a>

            <?php elseif ($file_type === 'text') :
                $contents = text_file_contents($asset_path);
                if ($contents) : ?>
                <div class="view-album__asset view-album__asset--text">
                    <div class="title-card">
                        <div class="title-card__head">
                            <?php echo $contents; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php else : ?>
            <!-- Error, uncrecognized file type: <?php echo $asset_path; ?> -->
            <?php endif; ?>
        </div>

        <?php endforeach; ?>
    </section>

</div>
